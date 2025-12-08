@extends('layouts.app')
@section('content')
<div class="card">
    <h1>Créer un nouveau template</h1>

    <form method="POST" action="{{ route('admin.templates.store') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Code *</label>
            <input type="text" name="code" value="{{ old('code') }}" 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
                   required>
            @error('code')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nom (Français) *</label>
            <input type="text" name="nom_fr" value="{{ old('nom_fr') }}" 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
                   required>
            @error('nom_fr')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nom (Anglais)</label>
            <input type="text" name="nom_en" value="{{ old('nom_en') }}" 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            @error('nom_en')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Chemin Blade *</label>
            <input type="text" name="chemin_blade" value="{{ old('chemin_blade') }}" 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
                   placeholder="Ex: factures.template1"
                   required>
            @error('chemin_blade')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Statut</label>
            <select name="actif" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <option value="1" {{ old('actif', 1) == '1' ? 'selected' : '' }}>Actif</option>
                <option value="0" {{ old('actif') == '0' ? 'selected' : '' }}>Inactif</option>
            </select>
            @error('actif')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Créer le template</button>
        <a href="{{ route('admin.templates.index') }}" class="btn btn-outline" style="margin-left: 10px;">Annuler</a>
    </form>
</div>
@endsection