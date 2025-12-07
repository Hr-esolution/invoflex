<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = auth()->user()->produits()->latest()->paginate(15);
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'categorie' => 'nullable|string|max:100',
        ]);


        auth()->user()->produits()->create([
            'nom' => $request->nom,
            'designation' => $request->designation,
            'prix_unitaire' => $request->prix_unitaire,
            'categorie' => $request->categorie,
            'actif' => true,
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        if ($produit->user_id !== auth()->id()) {
            abort(403);
        }
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        if ($produit->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'categorie' => 'nullable|string|max:100',
        ]);

        $produit->update([
            'nom' => $request->nom,
            'designation' => $request->designation,
            'prix_unitaire' => $request->prix_unitaire,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->user_id !== auth()->id()) {
            abort(403);
        }

        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }

    // Dans app/Http/Controllers/ProduitController.php

public function exportCsv()
{
    $produits = auth()->user()->produits()->get();

    $headers = [
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Content-type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=produits_' . date('Y-m-d') . '.csv',
        'Expires' => '0',
        'Pragma' => 'public'
    ];

    $callback = function() use ($produits) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Nom', 'Désignation', 'Catégorie', 'Prix unitaire (DH)']);
        foreach ($produits as $produit) {
            fputcsv($file, [
                $produit->nom,
                $produit->designation,
                $produit->categorie,
                $produit->prix_unitaire
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}