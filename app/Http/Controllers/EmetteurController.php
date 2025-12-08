<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EmetteurController extends Controller
{
    public function edit()
    {
        $emetteur = auth()->user()->emetteur()->firstOrNew();
        return view('parametres.emetteur', compact('emetteur'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:20',
            'pays' => 'nullable|string|max:100',
            'telephone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'ice' => 'nullable|string|max:20',
            'rc' => 'nullable|string|max:50',
            'patente' => 'nullable|string|max:50',
            'cnss' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Gestion du logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            if ($user->emetteur && $user->emetteur->logo_path) {
                Storage::disk('public')->delete('logos/' . $user->emetteur->logo_path);
            }
            $file = $request->file('logo');
            $logoPath = 'logo_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('logos', $logoPath, 'public');
        }

        $emetteurData = $request->only([
            'nom_entreprise', 'adresse', 'ville', 'code_postal', 'pays',
            'telephone', 'email', 'ice', 'rc', 'patente', 'cnss'
        ]);
        if ($logoPath) {
            $emetteurData['logo_path'] = $logoPath;
        }

        $user->emetteur()->updateOrCreate([], $emetteurData);

        return back()->with('success', 'Informations de l’émetteur mises à jour.');
    }
}