@extends('layouts.app')

@section('title', 'Nouveau produit')

@section('content')
<div class="card">
    <h1>Ajouter un produit</h1>

    <form method="POST" action="{{ route('produits.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap:24px; margin:24px 0;">
            <div>
                <label>Nom du produit *</label>
                <input type="text" name="nom" required style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;" value="{{ old('nom') }}">
            </div>
            <div>
                <label>Catégorie</label>
                <input type="text" name="categorie" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;" value="{{ old('categorie') }}">
            </div>
        </div>

        <div style="margin:24px 0;">
            <label>Désignation</label>
            <textarea name="designation" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px; height:80px;">{{ old('designation') }}</textarea>
        </div>

        <div style="margin:24px 0;">
            <label>Prix unitaire (DH) *</label>
            <input type="number" step="0.01" name="prix_unitaire" required style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;" value="{{ old('prix_unitaire') }}">
        </div>

        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Enregistrer le produit
        </button>
        <a href="{{ route('produits.index') }}" style="margin-left:12px; color:#6c757d;">Annuler</a>
    </form>
</div>
@endsection