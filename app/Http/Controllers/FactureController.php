<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\FactureTemplate;
use App\Models\FactureChamp;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FactureEnvoyee;
use Illuminate\Support\Facades\Mail;

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
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ];

        foreach ($champsActifs as $code) {
            $rules["valeurs_champs.{$code}"] = 'nullable|string|max:255';
        }

        $data = $request->validate($rules);

        // 🔒 Sécuriser les lignes
        $lignes = collect($data['lignes'])->map(function ($ligne) {
            return [
                'plat' => $ligne['plat'] ?? 'Produit non nommé',
                'designation' => $ligne['designation'] ?? '',
                'quantite' => $ligne['quantite'] ?? 1,
                'prix_unitaire' => $ligne['prix_unitaire'] ?? 0,
                'sous_total' => ($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0),
            ];
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
            'client_nom' => 'required|string|max:255',
            'template_id' => 'nullable|exists:facture_templates,id',
            'lignes' => 'required|array|min:1',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
        ];

        foreach ($champsActifs as $code) {
            $rules["valeurs_champs.{$code}"] = 'nullable|string|max:255';
        }

        $data = $request->validate($rules);

        $lignes = collect($data['lignes'])->map(function ($ligne) {
            return [
                'plat' => $ligne['plat'] ?? 'Produit non nommé',
                'designation' => $ligne['designation'] ?? '',
                'quantite' => $ligne['quantite'] ?? 1,
                'prix_unitaire' => $ligne['prix_unitaire'] ?? 0,
                'sous_total' => ($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0),
            ];
        });

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

    // ✅ Nouvelle méthode : liste produits JSON
    public function getProduits()
    {
        $produits = auth()->user()->produits()
            ->where('actif', true)
            ->select('id', 'nom', 'designation', 'prix_unitaire')
            ->get();

        return response()->json($produits);
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

        $locale = app()->getLocale();
        app()->setLocale($facture->user->lang ?? 'fr');

        $pdf = Pdf::loadView($cheminTemplate, compact('facture'));
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
        $cheminPrint = str_replace('pdf', 'print', $chemin);
        return view($cheminPrint, compact('facture'));
    }
}