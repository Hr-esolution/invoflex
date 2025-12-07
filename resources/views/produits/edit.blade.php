@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="card">
    <h1>Modifier le produit</h1>

    <form method="POST" action="{{ route('produits.update', $produit) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap:24px; margin:24px 0;">
            <div>
                <label>Nom du produit *</label>
                <input type="text" name="nom" required value="{{ old('nom', $produit->nom) }}" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
            <div>
                <label>Catégorie</label>
                <input type="text" name="categorie" value="{{ old('categorie', $produit->categorie) }}" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            </div>
        </div>

        <div style="margin:24px 0;">
            <label>Désignation</label>
            <textarea name="designation" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px; height:80px;">{{ old('designation', $produit->designation) }}</textarea>
        </div>

        <div style="margin:24px 0;">
            <label>Prix unitaire (DH) *</label>
            <input type="number" step="0.01" name="prix_unitaire" required value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
        </div>

        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Mettre à jour
        </button>
        <a href="{{ route('produits.index') }}" style="margin-left:12px; color:#6c757d;">Annuler</a>
    </form>
</div>
@endsection