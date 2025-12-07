<?php

namespace App\Http\Controllers;

use App\Models\FactureChamp;
use App\Models\FactureTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class FactureParametreController extends Controller
{
    /**
     * Affiche la page de configuration de facturation.
     */
    public function edit()
    {
        $user = auth()->user();

        // Charger ou initialiser les préférences
        $parametre = $user->factureParametre()->firstOrNew();
        $emetteur = $user->emetteur()->firstOrNew();

        // Données pour le formulaire
        $templates = FactureTemplate::where('actif', true)->get();
        $champs = FactureChamp::all();
        $langues = [
            'fr' => 'Français',
            'en' => 'English',
            'ar' => 'العربية',
        ];

        return view('parametres.facturation', compact(
            'parametre',
            'emetteur',
            'templates',
            'champs',
            'langues'
        ));
    }

    /**
     * Met à jour les paramètres de facturation et l'émetteur.
     */
    public function update(Request $request)
    {
        $request->validate([
            // Paramètres de facturation
            'template_defaut_id' => 'nullable|exists:facture_templates,id',
            'champs_actifs' => 'nullable|array',
            'champs_actifs.*' => 'exists:facture_champs,code',
            'mode_produit_defaut' => 'required|in:liste,manuel',
            'lang' => 'required|in:fr,en,ar',

            // Émetteur
            'emetteur.nom_entreprise' => 'required|string|max=255',
            'emetteur.adresse' => 'nullable|string|max=255',
            'emetteur.ville' => 'nullable|string|max=100',
            'emetteur.code_postal' => 'nullable|string|max=20',
            'emetteur.pays' => 'nullable|string|max=100',
            'emetteur.telephone' => 'nullable|string|max=30',
            'emetteur.email' => 'nullable|email|max=255',
            'emetteur.ice' => 'nullable|string|max=20',
            'emetteur.rc' => 'nullable|string|max=50',
            'emetteur.patente' => 'nullable|string|max=50',
            'emetteur.cnss' => 'nullable|string|max=50',
            'emetteur.logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2 Mo max
        ]);

        $user = auth()->user();

        // ───────────────────────────────
        // 1. Gestion du logo
        // ───────────────────────────────
        $logoPath = null;
        if ($request->hasFile('emetteur.logo')) {
            // Supprimer l'ancien logo
            if ($user->emetteur && $user->emetteur->logo_path) {
                Storage::disk('public')->delete('logos/' . $user->emetteur->logo_path);
            }

            $file = $request->file('emetteur.logo');
            $logoPath = 'logo_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('logos', $logoPath, 'public');
        }

        // ───────────────────────────────
        // 2. Sauvegarder l'émetteur
        // ───────────────────────────────
        $emetteurData = $request->emetteur ?? [];
        if ($logoPath) {
            $emetteurData['logo_path'] = $logoPath;
        }

        $user->emetteur()->updateOrCreate([], $emetteurData);

        // ───────────────────────────────
        // 3. Sauvegarder les préférences de facturation
        // ───────────────────────────────
        $user->factureParametre()->updateOrCreate([], [
            'template_defaut_id' => $request->template_defaut_id,
            'champs_actifs' => $request->champs_actifs ?? [],
            'mode_produit_defaut' => $request->mode_produit_defaut,
        ]);

        // ───────────────────────────────
        // 4. Mettre à jour la langue de l'utilisateur
        // ───────────────────────────────
        $user->update(['lang' => $request->lang]);

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}