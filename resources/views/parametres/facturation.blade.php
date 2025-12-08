@extends('layouts.app')

@section('title', 'Paramètres de facturation')

@section('content')
    <div class="card">
        <h1>Paramètres de facturation</h1>
        <p>Configurez votre template par défaut, les champs à afficher, et le mode de saisie des produits.</p>

        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:12px; border-radius:6px; margin:20px 0;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('facturation.parametres') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Langue -->
            <div style="margin: 24px 0;">
                <h3>Langue de l'interface et des factures</h3>
                <div style="display: flex; gap: 16px; margin-top: 12px;">
                    @foreach($langues as $code => $label)
                        <label style="display: flex; align-items: center; gap: 6px;">
                            <input type="radio" name="lang" value="{{ $code }}" {{ (auth()->user()->lang ?? 'fr') == $code ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

    </div>
    <!-- Template par défaut -->
    <div style="margin: 24px 0;">
        <h3>Template de facture par défaut</h3>
        <p style="color:#6c757d; margin:8px 0;">Le template utilisé lors de la création d'une nouvelle facture.</p>
        <select name="template_defaut_id" style="width:100%; padding:10px; border:1px solid #ced4da; border-radius:6px;">
            <option value="">-- Aucun (utiliser le template standard)</option>
            @foreach($templates as $template)
                <option value="{{ $template->id }}" {{ ($parametre->template_defaut_id == $template->id) ? 'selected' : '' }}>
                    {{ $template->nom_fr }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Champs à activer -->
    <div style="margin: 24px 0;">
        <h3>Champs à afficher dans les factures</h3>
        <p style="color:#6c757d; margin:8px 0;">Sélectionnez les champs que vous souhaitez utiliser.</p>
        <div
            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:12px; margin-top:12px;">
            @foreach($champs as $champ)
                <label style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="champs_actifs[]" value="{{ $champ->code }}" {{ in_array($champ->code, $parametre->champs_actifs ?? []) ? 'checked' : '' }}>
                    {{ $champ->nom_fr }}
                </label>
            @endforeach
        </div>
    </div>

    <!-- Mode produit -->
    <div style="margin: 24px 0;">
        <h3>Mode de saisie des produits par défaut</h3>
        <div style="display:flex; gap:24px; margin-top:12px;">
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="radio" name="mode_produit_defaut" value="liste" {{ ($parametre->mode_produit_defaut ?? 'liste') == 'liste' ? 'checked' : '' }}>
                Depuis la liste enregistrée
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="radio" name="mode_produit_defaut" value="manuel" {{ ($parametre->mode_produit_defaut ?? 'liste') == 'manuel' ? 'checked' : '' }}>
                Saisie manuelle
            </label>
        </div>
    </div>

    <button type="submit" class="btn" style="margin-top:20px;">
        <i class="fas fa-save"></i> Enregistrer les paramètres
    </button>
    </form>
    </div>
@endsection