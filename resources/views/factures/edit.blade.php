@extends('layouts.app')

@section('title', "Modifier la facture #{$facture->id}")

@section('content')
<div class="card">
    <h1>Modifier la facture #{{ $facture->id }}</h1>

    <form method="POST" action="{{ route('factures.update', $facture) }}">
        @csrf
        @method('PUT')

        <!-- Client -->
        <div style="margin: 24px 0;">
            <h3>Informations client</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:16px; margin-top:12px;">
                <div>
                    <label>Nom du client *</label>
                    <input type="text" name="client_nom" value="{{ old('client_nom', $facture->client_nom) }}" required 
                           style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
                </div>
                <div>
                    <label>Téléphone</label>
                    <input type="text" name="client_tel" value="{{ old('client_tel', $facture->client_tel) }}" 
                           style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
                </div>
                <div>
                    <label>Adresse</label>
                    <input type="text" name="client_adresse" value="{{ old('client_adresse', $facture->client_adresse) }}" 
                           style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
                </div>
                <div>
                    <label>ICE</label>
                    <input type="text" name="client_ice" value="{{ old('client_ice', $facture->client_ice) }}" 
                           style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
                </div>
            </div>
        </div>

        <!-- Template -->
        <div style="margin: 24px 0;">
            <h3>Template de facture</h3>
            <select name="template_id" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
                <option value="">-- Aucun (utiliser standard)</option>
                @foreach($templates as $template)
                    <option value="{{ $template->id }}" {{ $facture->template_id == $template->id ? 'selected' : '' }}>
                        {{ $template->nom_fr }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Champs dynamiques -->
        @if($champs->isNotEmpty())
        <div style="margin: 24px 0;">
            <h3>Champs supplémentaires</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-top:12px;">
                @foreach($champs as $champ)
                    <div>
                        <label>{{ $champ->nom_fr }}</label>
                        <input 
                            type="text" 
                            name="valeurs_champs[{{ $champ->code }}]" 
                            value="{{ old('valeurs_champs.' . $champ->code, $facture->valeurs_champs[$champ->code] ?? '') }}"
                            style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- TVA -->
        <div style="margin: 24px 0;">
            <label>
                <input type="checkbox" name="tva_applicable" value="1" {{ $facture->tva_applicable ? 'checked' : '' }}>
                Appliquer la TVA (20%)
            </label>
        </div>

        <!-- Produits enregistrés -->
        <div style="margin: 24px 0;">
            <h3>Produits enregistrés</h3>
            <button type="button" onclick="openProduitsModal()" class="btn" style="background:#17a2b8;">
                <i class="fas fa-list"></i> Sélectionner depuis la liste
            </button>
        </div>

        <!-- Lignes de facture -->
        <div style="margin: 24px 0;">
            <h3>Produits de la facture</h3>
            <div id="lignes-facture">
                @foreach($facture->lignes as $index => $ligne)
    @php
        $ligne = array_merge([
            'plat' => '',
            'designation' => '',
            'quantite' => 1,
            'prix_unitaire' => 0,
            'sous_total' => 0,
        ], $ligne);
    @endphp
                <div class="ligne" style="display: grid; grid-template-columns: 2fr 3fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:12px; align-items:end;">
                    <div>
                        <input type="text" name="lignes[{{ $index }}][plat]" value="{{ $ligne['plat'] }}" required 
                               style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                    </div>
                    <div>
                        <input type="text" name="lignes[{{ $index }}][designation]" value="{{ $ligne['designation'] }}" 
                               style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                    </div>
                    <div>
                        <input type="number" name="lignes[{{ $index }}][quantite]" value="{{ $ligne['quantite'] }}" min="1" required 
                               style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                    </div>
                    <div>
                        <input type="number" step="0.01" name="lignes[{{ $index }}][prix_unitaire]" value="{{ $ligne['prix_unitaire'] }}" required 
                               style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                    </div>
                    <div>
                        <input type="text" value="{{ number_format($ligne['sous_total'] ?? 0, 2) }}" readonly 
                               style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; background:#f8f9fa;">
                    </div>
                    <button type="button" onclick="removeLigne(this)" style="background:#dc3545; color:white; border:none; border-radius:4px; height:36px;">✕</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addLigne()" style="background:#28a745; color:white; border:none; padding:8px 16px; border-radius:6px; margin-top:10px;">
                + Ajouter un produit manuellement
            </button>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Mettre à jour la facture
            </button>
            <a href="{{ route('factures.index') }}" style="margin-left:12px; color:#6c757d;">Annuler</a>
        </div>
    </form>
</div>

<!-- Modal produits -->
<div id="produitsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:white; margin:50px auto; padding:24px; width:90%; max-width:800px; border-radius:12px; max-height:80vh; overflow:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3>Choisir un produit</h3>
            <button onclick="closeProduitsModal()" style="background:#dc3545; color:white; border:none; width:32px; height:32px; border-radius:50%;">✕</button>
        </div>
        <div id="liste-produits" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:12px;">
            <!-- Chargé via AJAX -->
        </div>
    </div>
</div>

<script>
function openProduitsModal() {
    document.getElementById('produitsModal').style.display = 'block';
    fetch("{{ route('api.produits') }}")
        .then(response => response.json())
        .then(produits => {
            const container = document.getElementById('liste-produits');
            container.innerHTML = '';
            if (produits.length === 0) {
                container.innerHTML = '<p>Aucun produit enregistré. <a href="{{ route("produits.index") }}">Créez-en un</a>.</p>';
                return;
            }
            produits.forEach(p => {
                const div = document.createElement('div');
                div.style.border = "1px solid #e0e0e0";
                div.style.borderRadius = "8px";
                div.style.padding = "12px";
                div.style.cursor = "pointer";
                div.innerHTML = `
                    <strong>${p.nom}</strong><br>
                    <small>${p.designation || ''}</small><br>
                    <strong>${parseFloat(p.prix_unitaire).toFixed(2)} DH</strong>
                `;
                div.onclick = () => {
                    addLigneFromProduit(p.nom, p.designation || '', p.prix_unitaire);
                    closeProduitsModal();
                };
                container.appendChild(div);
            });
        });
}

function closeProduitsModal() {
    document.getElementById('produitsModal').style.display = 'none';
}

function addLigne() {
    const container = document.getElementById('lignes-facture');
    const index = container.children.length;
    const template = `
        <div class="ligne" style="display: grid; grid-template-columns: 2fr 3fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:12px; align-items:end;">
            <div><input type="text" name="lignes[${index}][plat]" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="text" name="lignes[${index}][designation]" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="number" name="lignes[${index}][quantite]" value="1" min="1" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="number" step="0.01" name="lignes[${index}][prix_unitaire]" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="text" readonly style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; background:#f8f9fa;"></div>
            <button type="button" onclick="removeLigne(this)" style="background:#dc3545; color:white; border:none; border-radius:4px; height:36px;">✕</button>
        </div>`;
    container.insertAdjacentHTML('beforeend', template);
}

function addLigneFromProduit(plat, designation, prix) {
    const container = document.getElementById('lignes-facture');
    const index = container.children.length;
    const template = `
        <div class="ligne" style="display: grid; grid-template-columns: 2fr 3fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:12px; align-items:end;">
            <div><input type="text" name="lignes[${index}][plat]" value="${plat}" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="text" name="lignes[${index}][designation]" value="${designation}" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="number" name="lignes[${index}][quantite]" value="1" min="1" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="number" step="0.01" name="lignes[${index}][prix_unitaire]" value="${prix}" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div><input type="text" readonly style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; background:#f8f9fa;"></div>
            <button type="button" onclick="removeLigne(this)" style="background:#dc3545; color:white; border:none; border-radius:4px; height:36px;">✕</button>
        </div>`;
    container.insertAdjacentHTML('beforeend', template);
}

function removeLigne(button) {
    if (document.querySelectorAll('#lignes-facture .ligne').length > 1) {
        button.closest('.ligne').remove();
    }
}
</script>
@endsection