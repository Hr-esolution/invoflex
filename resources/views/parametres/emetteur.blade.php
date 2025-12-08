@extends('layouts.app')

@section('title', 'Émetteur de facture')

@section('content')
<div class="card">
    <h1>Configurer l’émetteur de facture</h1>
    <p>Ces informations apparaîtront sur toutes vos factures.</p>

    <form method="POST" action="{{ route('emetteur.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:16px; margin:24px 0;">
            <div>
                <label>Nom de l'entreprise *</label>
                <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise', $emetteur->nom_entreprise) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;" required>
            </div>
            <div>
                <label>Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse', $emetteur->adresse) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Ville</label>
                <input type="text" name="ville" value="{{ old('ville', $emetteur->ville) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Code postal</label>
                <input type="text" name="code_postal" value="{{ old('code_postal', $emetteur->code_postal) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Pays</label>
                <input type="text" name="pays" value="{{ old('pays', $emetteur->pays) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $emetteur->telephone) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $emetteur->email) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>ICE (Maroc)</label>
                <input type="text" name="ice" value="{{ old('ice', $emetteur->ice) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>RC</label>
                <input type="text" name="rc" value="{{ old('rc', $emetteur->rc) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Patente</label>
                <input type="text" name="patente" value="{{ old('patente', $emetteur->patente) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Affiliation CNSS</label>
                <input type="text" name="cnss" value="{{ old('cnss', $emetteur->cnss) }}" 
                       style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
        </div>

        <!-- Logo -->
        <div style="margin:24px 0;">
            <label>Logo de l'entreprise</label>
            <input type="file" name="logo" accept="image/*" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:6px; margin-top:6px;">
            @if($emetteur->logo_path)
                <div style="margin-top:10px;">
                    <img src="{{ asset('storage/logos/' . $emetteur->logo_path) }}" 
                         alt="Logo" style="max-height:80px; max-width:200px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn" style="background:#4361ee; color:white;">
            <i class="fas fa-save"></i> Enregistrer l’émetteur
        </button>
    </form>
</div>
@endsection