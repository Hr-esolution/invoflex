@extends('layouts.app')

@section('title', 'Mes Produits')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Mes Produits</h1>
        <a href="{{ route('produits.export') }}" class="btn" style="background:#28a745; margin-right:10px;">
            <i class="fas fa-file-csv"></i> Exporter CSV
        </a>
        <a href="{{ route('produits.create') }}" class="btn">
            <i class="fas fa-plus"></i> Nouveau produit
        </a>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:12px; border-radius:6px; margin:20px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if($produits->isEmpty())
        <p>Aucun produit enregistré.</p>
    @else
        <table style="width:100%; border-collapse: collapse; margin-top:20px;">
            <thead>
                <tr style="background:#f8f9fa;">
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Nom</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Désignation</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Catégorie</th>
                    <th style="padding:12px; text-align:right; border-bottom:1px solid #dee2e6;">Prix (DH)</th>
                    <th style="padding:12px; text-align:right; border-bottom:1px solid #dee2e6;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produits as $produit)
                    <tr>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $produit->nom }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $produit->designation }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $produit->categorie ?? '-' }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef; text-align:right;">{{ number_format($produit->prix_unitaire, 2) }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef; text-align:right;">
                            <a href="{{ route('produits.edit', $produit) }}" style="color:#4361ee; margin-right:10px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('produits.destroy', $produit) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ?')" style="background:none; border:none; color:#dc3545; cursor:pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $produits->links() }}
        </div>
    @endif
</div>
@endsection