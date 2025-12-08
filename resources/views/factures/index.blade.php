@extends('layouts.app')

@section('title', 'Mes Factures')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Mes Factures</h1>
        <a href="{{ route('factures.create') }}" class="btn">
            <i class="fas fa-plus"></i> Nouvelle facture
        </a>
    </div>

    @if($factures->isEmpty())
        <p>Aucune facture créée pour le moment.</p>
    @else
        <table style="width:100%; border-collapse: collapse; margin-top:20px;">
            <thead>
                <tr style="background:#f8f9fa;">
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">N°</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Client</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Total TTC</th>
                    <th style="padding:12px; text-align:left; border-bottom:1px solid #dee2e6;">Date</th>
                    <th style="padding:12px; text-align:right; border-bottom:1px solid #dee2e6;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                    <tr>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $facture->id }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $facture->client_nom }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ number_format($facture->total_ttc, 2) }}
                            DH</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $facture->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef; text-align:right;">
                            <!-- Modifier -->
                            <a href="{{ route('factures.edit', $facture) }}"
                                style="color:#4361ee; margin-right:10px; text-decoration:none;" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- PDF -->
                            <a href="{{ route('factures.pdf', $facture->id) }}" target="_blank"
                                style="color:#e74c3c; margin-right:10px; text-decoration:none;" title="PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>

                            <!-- Dupliquer -->
                            <form action="{{ route('factures.duplicate', $facture) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                    style="background:none; border:none; color:#28a745; cursor:pointer; padding:0; margin-right:10px;"
                                    title="Dupliquer">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </form>
                            <!-- Email -->
                            <form action="{{ route('factures.email', $facture) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                    style="background:none; border:none; color:#6f42c1; cursor:pointer; margin-right:10px;"
                                    title="Envoyer par email">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </form>
                            <a href="{{ route('factures.pdf', $facture) }}" target="_blank" class="btn"
                                style="background:#6c757d;">
                                <i class="fas fa-print"></i> Version imprimable
                            </a>
                            <!-- Supprimer -->
                            <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')"
                                    style="background:none; border:none; color:#dc3545; cursor:pointer; padding:0;"
                                    title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $factures->links() }}
        </div>
    @endif
</div>