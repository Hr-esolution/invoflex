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
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ number_format($facture->total_ttc, 2) }} DH</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef;">{{ $facture->created_at->format('d/m/Y') }}</td>
                        <td style="padding:12px; border-bottom:1px solid #e9ecef; text-align:right;">
                            <!-- Modifier -->
                            <a href="{{ route('factures.edit', $facture) }}" 
                               style="color:#4361ee; margin-right:10px; text-decoration:none;" 
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- PDF -->
                            <a href="{{ route('factures.pdf', $facture->id) }}" 
                               target="_blank" 
                               style="color:#e74c3c; margin-right:10px; text-decoration:none;" 
                               title="PDF">
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
<a href="{{ route('factures.pdf', $facture) }}" target="_blank" class="btn" style="background:#6c757d;">
    <i class="fas fa-print"></i> Version imprimable
</a>
<!-- Google Drive -->
@if(auth()->user()->google_drive_token)
    <!-- Sauvegarder dans Google Drive (privé) -->
    <form action="{{ route('factures.save-to-drive', $facture) }}" method="POST" style="display:inline;">
        @csrf
        <input type="hidden" name="share_type" value="private">
        <button type="submit" 
                style="background:none; border:none; color:#4285F4; cursor:pointer; margin-right:10px;"
                title="Sauvegarder dans Google Drive (privé)">
            <i class="fab fa-google-drive"></i>
        </button>
    </form>
    
    <!-- Sauvegarder et partager avec lien -->
    <form action="{{ route('factures.save-to-drive', $facture) }}" method="POST" style="display:inline;">
        @csrf
        <input type="hidden" name="share_type" value="anyone_with_link">
        <button type="submit" 
                style="background:none; border:none; color:#34A853; cursor:pointer; margin-right:10px;"
                title="Sauvegarder et partager publiquement">
            <i class="fas fa-link"></i>
        </button>
    </form>
    
    <!-- Sauvegarder et partager par email -->
    <button onclick="showShareModal({{ $facture->id }})" 
            style="background:none; border:none; color:#EA4335; cursor:pointer; margin-right:10px;"
            title="Sauvegarder et partager par email">
        <i class="fas fa-envelope"></i>
    </button>
@else
    <a href="{{ route('google.drive.connect') }}" 
       style="color:#4285F4; margin-right:10px;" 
       title="Connecter Google Drive">
        <i class="fab fa-google-drive"></i>
    </a>
@endif
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

<!-- Modal pour le partage par email -->
<div id="shareModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; width: 400px; max-width: 90%;">
        <h3>Partager la facture par email</h3>
        <form id="shareForm" method="POST" style="margin-top: 15px;">
            @csrf
            <input type="hidden" name="share_type" value="specific_email">
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px;">Adresse email du destinataire:</label>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="hideShareModal()" style="margin-right: 10px; padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Annuler</button>
                <button type="submit" style="padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Partager</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentFactureId = null;

    function showShareModal(factureId) {
        currentFactureId = factureId;
        const form = document.getElementById('shareForm');
        form.action = `/factures/${factureId}/save-to-drive`;
        document.getElementById('shareModal').style.display = 'block';
    }

    function hideShareModal() {
        document.getElementById('shareModal').style.display = 'none';
        document.getElementById('email').value = '';
    }

    // Fermer le modal si on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('shareModal');
        if (event.target === modal) {
            hideShareModal();
        }
    }
</script>
@endsection