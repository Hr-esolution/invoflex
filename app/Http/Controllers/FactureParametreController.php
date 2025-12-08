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
 

public function edit()
{
    $user = auth()->user();
    $parametre = $user->factureParametre()->firstOrNew();

    $templates = FactureTemplate::where('actif', true)->get();
    $champs = FactureChamp::all();
    $langues = ['fr' => 'Français', 'en' => 'English', 'ar' => 'العربية'];

    return view('parametres.facturation', compact('parametre', 'templates', 'champs', 'langues'));
}

public function update(Request $request)
{
    $request->validate([
        'template_defaut_id' => 'nullable|exists:facture_templates,id',
        'champs_actifs' => 'nullable|array',
        'champs_actifs.*' => 'exists:facture_champs,code',
        'mode_produit_defaut' => 'required|in:liste,manuel',
        'lang' => 'required|in:fr,en,ar',
    ]);

    $user = auth()->user();

    $user->factureParametre()->updateOrCreate([], [
        'template_defaut_id' => $request->template_defaut_id,
        'champs_actifs' => $request->champs_actifs ?? [],
        'mode_produit_defaut' => $request->mode_produit_defaut,
    ]);

    $user->update(['lang' => $request->lang]);

    return back()->with('success', 'Paramètres de facturation mis à jour.');
}
}