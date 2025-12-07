<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive as DriveService;

class GoogleDriveController extends Controller
{
    /**
     * Redirige l'utilisateur vers Google pour l'autorisation.
     */
    public function connect()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->setRedirectUri(route('google.drive.callback'));
        $client->addScope(DriveService::DRIVE_FILE);
        $client->setAccessType('offline');      // Obligatoire pour refresh_token
        $client->setPrompt('consent');          // Force le refresh_token à chaque fois (utile en dev)

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    /**
     * Gère le callback OAuth2 de Google.
     */
    public function callback(Request $request)
    {
        // Cas d'annulation
        if (! $request->has('code')) {
            return redirect()->route('factures.index')
                             ->withErrors('Connexion à Google Drive annulée.');
        }

        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->setRedirectUri(route('google.drive.callback'));
        $client->addScope(DriveService::DRIVE_FILE);

        try {
            $token = $client->fetchAccessTokenWithAuthCode($request->code);
        } catch (\Exception $e) {
            \Log::error('Google Drive OAuth error: ' . $e->getMessage());
            return redirect()->route('factures.index')
                             ->withErrors('Erreur lors de la connexion à Google Drive. Veuillez réessayer.');
        }

        // Récupère le refresh_token (nécessaire pour les requêtes futures)
        $refreshToken = $token['refresh_token'] ?? auth()->user()->google_drive_refresh_token;

        // Si c'est la première connexion et qu'il n'y a pas de refresh_token → erreur
        if (! $refreshToken) {
            return redirect()->route('factures.index')
                             ->withErrors('Erreur critique : Google n’a pas fourni de refresh token. '
                                        . 'Veuillez vous déconnecter de votre compte Google et réessayer.');
        }

        // Sauvegarde les tokens dans la base
        auth()->user()->update([
            'google_drive_token' => $token['access_token'],
            'google_drive_refresh_token' => $refreshToken,
            'google_drive_token_expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
        ]);

        return redirect()->route('factures.index')
                         ->with('success', '✅ Votre compte Google Drive est maintenant connecté !');
    }
}