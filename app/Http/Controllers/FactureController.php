<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\FactureTemplate;
use App\Models\FactureChamp;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
    use App\Mail\FactureEnvoyee;
use Illuminate\Support\Facades\Mail;
use Google\Client;
use Google\Service\Drive as DriveService;
use Google\Service\Drive\DriveFile;
class FactureController extends Controller
{


    public function index()
    {
        $factures = auth()->user()->factures()->latest()->paginate(10);
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $user = auth()->user();
        $parametre = $user->factureParametre()->first();
        $templateDefautId = $parametre?->template_defaut_id;
        $champsActifs = $parametre?->champs_actifs ?? [];

        $templates = FactureTemplate::where('actif', true)->get();
        $champs = FactureChamp::whereIn('code', $champsActifs)->get();

        return view('factures.create', compact(
            'templates',
            'templateDefautId',
            'champs'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $parametre = $user->factureParametre()->first();
        $champsActifs = $parametre?->champs_actifs ?? [];

        $rules = [
            'client_nom' => 'required|string|max:255',
            'template_id' => 'nullable|exists:facture_templates,id',
            'lignes' => 'required|array|min:1',
            'lignes.*.quantite' => 'required|integer|min=1',
            'lignes.*.prix_unitaire' => 'required|numeric|min=0',
        ];

        foreach ($champsActifs as $code) {
            $rules["valeurs_champs.{$code}"] = 'nullable|string|max=255';
        }

        $data = $request->validate($rules);

        $lignes = collect($data['lignes'])->map(function ($ligne) {
            $ligne['sous_total'] = $ligne['quantite'] * $ligne['prix_unitaire'];
            return $ligne;
        });

        $totalHT = $lignes->sum('sous_total');
        $tva = !empty($data['tva_applicable']) ? $totalHT * 0.20 : 0;
        $totalTTC = $totalHT + $tva;

        $facture = Facture::create([
            'user_id' => $user->id,
            'client_nom' => $data['client_nom'],
            'client_tel' => $data['client_tel'] ?? null,
            'client_adresse' => $data['client_adresse'] ?? null,
            'client_ice' => $data['client_ice'] ?? null,
            'tva_applicable' => !empty($data['tva_applicable']),
            'total_ht' => $totalHT,
            'tva' => $tva,
            'total_ttc' => $totalTTC,
            'lignes' => $lignes,
            'template_id' => $data['template_id'] ?? null,
            'valeurs_champs' => $data['valeurs_champs'] ?? [],
        ]);

        return redirect()->route('factures.index')
                         ->with('success', 'Facture créée avec succès.');
    }

    public function show(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403);
        }
        // Optionnel : vue détail (tu peux la créer si besoin)
        return view('factures.show', compact('facture'));
    }

    public function edit(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $parametre = $user->factureParametre()->first();
        $champsActifs = $parametre?->champs_actifs ?? [];

        $templates = FactureTemplate::where('actif', true)->get();
        $champs = FactureChamp::whereIn('code', $champsActifs)->get();

        return view('factures.edit', compact('facture', 'templates', 'champs'));
    }

    public function update(Request $request, Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $parametre = $user->factureParametre()->first();
        $champsActifs = $parametre?->champs_actifs ?? [];

        $rules = [
            'client_nom' => 'required|string|max=255',
            'template_id' => 'nullable|exists:facture_templates,id',
            'lignes' => 'required|array|min=1',
            'lignes.*.quantite' => 'required|integer|min=1',
            'lignes.*.prix_unitaire' => 'required|numeric|min=0',
        ];

        foreach ($champsActifs as $code) {
            $rules["valeurs_champs.{$code}"] = 'nullable|string|max=255';
        }

        $data = $request->validate($rules);

        $lignes = collect($data['lignes'])->map(fn($l) => $l + [
            'sous_total' => $l['quantite'] * $l['prix_unitaire']
        ]);

        $totalHT = $lignes->sum('sous_total');
        $tva = !empty($data['tva_applicable']) ? $totalHT * 0.20 : 0;
        $totalTTC = $totalHT + $tva;

        $facture->update([
            'client_nom' => $data['client_nom'],
            'client_tel' => $data['client_tel'] ?? null,
            'client_adresse' => $data['client_adresse'] ?? null,
            'client_ice' => $data['client_ice'] ?? null,
            'tva_applicable' => !empty($data['tva_applicable']),
            'total_ht' => $totalHT,
            'tva' => $tva,
            'total_ttc' => $totalTTC,
            'lignes' => $lignes,
            'template_id' => $data['template_id'] ?? null,
            'valeurs_champs' => $data['valeurs_champs'] ?? [],
        ]);

        return redirect()->route('factures.index')
                         ->with('success', 'Facture mise à jour avec succès.');
    }

    public function destroy(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403);
        }

        $facture->delete();
        return redirect()->route('factures.index')
                         ->with('success', 'Facture supprimée avec succès.');
    }

   public function facturePdf($id)
{
    $facture = Facture::with(['template', 'user.emetteur'])->findOrFail($id);
    $cheminTemplate = $facture->template?->chemin_blade ?? 'factures.templates.standard';
    // Sauvegarder la langue actuelle
$locale = app()->getLocale();

// Appliquer la langue de l'utilisateur
app()->setLocale($facture->user->lang ?? 'fr');

// Générer le PDF
$pdf = Pdf::loadView($cheminTemplate, compact('facture'));

// Restaurer la langue
app()->setLocale($locale);
    return $pdf->stream("facture_{$facture->id}.pdf");
}

    public function duplicate(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403);
        }

        $nouvelle = $facture->replicate();
        $nouvelle->created_at = now();
        $nouvelle->save();

        return redirect()->route('factures.edit', $nouvelle)
                         ->with('success', 'Facture dupliquée avec succès.');
    }
    public function envoyerEmail(Facture $facture)
{
    if ($facture->user_id !== auth()->id()) {
        abort(403);
    }

    if (! $facture->client_email) {
        return back()->withErrors('L’adresse email du client est requise.');
    }

    Mail::to($facture->client_email)->send(new FactureEnvoyee($facture));

    return back()->with('success', 'Facture envoyée par email avec succès.');
}
public function printable($id)
{
    $facture = Facture::with(['template', 'user.emetteur'])->findOrFail($id);
    $chemin = $facture->template?->chemin_blade ?? 'factures.templates.standard';
    // Remplacer "pdf" par "print"
    $cheminPrint = str_replace('pdf', 'print', $chemin);
    return view($cheminPrint, compact('facture'));
}


// Dans FactureController.php



public function saveToDrive(Request $request, Facture $facture)
{
    if ($facture->user_id !== auth()->id()) {
        abort(403);
    }

    $user = auth()->user();
    if (! $user->google_drive_token) {
        return back()->withErrors('Veuillez d’abord connecter votre compte Google Drive.');
    }

    // Vérifier si le token est expiré
    if ($user->google_drive_token_expires_at->isPast()) {
        // Refresh le token
        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $newToken = $client->fetchAccessTokenWithRefreshToken($user->google_drive_refresh_token);

        $user->update([
            'google_drive_token' => $newToken['access_token'],
            'google_drive_token_expires_at' => now()->addSeconds($newToken['expires_in']),
        ]);
    }

    // Générer le PDF
    $pdf = \\Barryvdh\\DomPDF\\Facade\\Pdf::loadView(
        $facture->template?->chemin_blade ?? 'factures.templates.standard',
        ['facture' => $facture->load('user.emetteur')]
    );

    // Uploader dans Google Drive
    $client = new Client();
    $client->setAccessToken($user->google_drive_token);

    $driveService = new DriveService($client);
    
    // Créer le fichier dans Google Drive
    $fileMetadata = new DriveFile([
        'name' => "facture_{$facture->id}.pdf",
        'mimeType' => 'application/pdf',
    ]);

    $content = $pdf->output();
    $stream = fopen('php://memory', 'r+');
    fwrite($stream, $content);
    rewind($stream);

    $file = $driveService->files->create($fileMetadata, [
        'data' => $stream,
        'mimeType' => 'application/pdf',
        'uploadType' => 'multipart',
        'fields' => 'id,webViewLink,webContentLink'
    ]);

    fclose($stream);

    // Déterminer le type de partage demandé
    $shareType = $request->input('share_type', 'private'); // private, anyone_with_link, or specific_email

    if ($shareType === 'anyone_with_link') {
        // Partager avec n'importe qui ayant le lien
        $driveService->permissions->create($file->id, new \\Google\\Service\\Drive\\Permission([
            'type' => 'anyone',
            'role' => 'reader'
        ]));
        
        $message = 'Facture sauvegardée et partagée publiquement dans Google Drive !';
    } elseif ($shareType === 'specific_email' && $request->filled('email')) {
        // Partager avec une adresse email spécifique
        $driveService->permissions->create($file->id, new \\Google\\Service\\Drive\\Permission([
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $request->email
        ]));
        
        $message = 'Facture sauvegardée et partagée avec ' . $request->email . ' dans Google Drive !';
    } else {
        // Fichier privé par défaut
        $message = 'Facture sauvegardée dans votre Google Drive !';
    }

    return back()->with('success', $message);
}

}