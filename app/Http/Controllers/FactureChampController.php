<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FactureChamp;
use Illuminate\Http\Request;

class FactureChampController extends Controller
{
    public function index()
    {
        $champs = FactureChamp::latest()->paginate(15);
        return view('admin.champs.index', compact('champs'));
    }

    public function create()
    {
        return view('admin.champs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:facture_champs,code',
            'nom_fr' => 'required|string|max=255',
            'type' => 'required|in:text,number,date,boolean',
        ]);

        FactureChamp::create($request->all());

        return redirect()->route('admin.champs.index')
                         ->with('success', 'Champ international ajouté.');
    }

    public function edit(FactureChamp $champ)
    {
        return view('admin.champs.edit', compact('champ'));
    }

    public function update(Request $request, FactureChamp $champ)
    {
        $request->validate([
            'code' => 'required|string|unique:facture_champs,code,' . $champ->id,
            'nom_fr' => 'required|string|max=255',
            'type' => 'required|in:text,number,date,boolean',
        ]);

        $champ->update($request->all());

        return redirect()->route('admin.champs.index')
                         ->with('success', 'Champ mis à jour.');
    }

    public function destroy(FactureChamp $champ)
    {
        $champ->delete();
        return back()->with('success', 'Champ supprimé.');
    }
}