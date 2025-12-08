<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FactureTemplate;
use Illuminate\Http\Request;

class FactureTemplateController extends Controller
{
    public function index()
    {
        $templates = FactureTemplate::latest()->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:facture_templates,code',
            'nom_fr' => 'required|string|max:255',
            'nom_en' => 'nullable|string|max=255',
            'chemin_blade' => 'required|string',
        ]);

        FactureTemplate::create($request->all());

        return redirect()->route('admin.templates.index')
                         ->with('success', 'Template créé avec succès.');
    }

    public function edit(FactureTemplate $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, FactureTemplate $template)
    {
        $request->validate([
            'code' => 'required|string|unique:facture_templates,code,' . $template->id,
            'nom_fr' => 'required|string|max=255',
            'nom_en' => 'nullable|string|max=255',
            'chemin_blade' => 'required|string',
        ]);

        $template->update($request->all());

        return redirect()->route('admin.templates.index')
                         ->with('success', 'Template mis à jour.');
    }

    public function destroy(FactureTemplate $template)
    {
        $template->delete();
        return back()->with('success', 'Template supprimé.');
    }
}