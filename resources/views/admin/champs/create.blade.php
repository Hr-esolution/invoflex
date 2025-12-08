@extends('layouts.app')
@section('content')
<div class="card">
    <h1>Ajouter un nouveau champ</h1>

    <form method="POST" action="{{ route('admin.champs.store') }}">
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
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Type *</label>
            <select name="type" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" required>
                <option value="">Sélectionner un type</option>
                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Texte</option>
                <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Nombre</option>
                <option value="date" {{ old('type') == 'date' ? 'selected' : '' }}>Date</option>
                <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Booléen</option>
            </select>
            @error('type')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
            <textarea name="description" rows="3" 
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">{{ old('description') }}</textarea>
            @error('description')
                <div style="color: #dc3545; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Créer le champ</button>
        <a href="{{ route('admin.champs.index') }}" class="btn btn-outline" style="margin-left: 10px;">Annuler</a>
    </form>
</div>
@endsection