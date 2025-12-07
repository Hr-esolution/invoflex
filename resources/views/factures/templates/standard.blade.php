<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; color: #333; }
        .info-section { margin-bottom: 20px; }
        .info-block { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .totals { margin-top: 20px; text-align: right; }
        .totals div { margin: 6px 0; font-weight: bold; }
        .champ { margin: 4px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>FACTURE</h2>
        <p>N° {{ $facture->id }} — {{ $facture->created_at->format('d/m/Y') }}</p>
    </div>

    <!-- Émetteur -->
   <!-- Émetteur -->
<div class="info-section">
    <strong>Émetteur :</strong><br>
    {{ $facture->user->emetteur?->nom_entreprise ?? config('app.name') }}<br>
    @if($facture->user->emetteur?->adresse)
        {{ $facture->user->emetteur->adresse }}<br>
    @endif
    @if($facture->user->emetteur?->ville)
        {{ $facture->user->emetteur->ville }}
        @if($facture->user->emetteur?->code_postal)
            {{ $facture->user->emetteur->code_postal }}
        @endif
        @if($facture->user->emetteur?->pays)
            — {{ $facture->user->emetteur->pays }}
        @endif
        <br>
    @endif
    @if($facture->user->emetteur?->telephone)
        Tél: {{ $facture->user->emetteur->telephone }}<br>
    @endif
    @if($facture->user->emetteur?->email)
        Email: {{ $facture->user->emetteur->email }}<br>
    @endif
    @if($facture->user->emetteur?->ice)
        ICE: {{ $facture->user->emetteur->ice }}<br>
    @endif
</div>

    <!-- Client -->
    <div class="info-section">
        <strong>Client :</strong><br>
        {{ $facture->client_nom }}<br>
        @if($facture->client_tel)<strong>Tél :</strong> {{ $facture->client_tel }}<br>@endif
        @if($facture->client_adresse)<strong>Adresse :</strong> {{ $facture->client_adresse }}<br>@endif
        @if($facture->client_ice)<strong>ICE :</strong> {{ $facture->client_ice }}<br>@endif
    </div>

    <!-- Champs dynamiques -->
    @if($facture->valeurs_champs)
        @foreach($facture->valeurs_champs as $code => $valeur)
            @if(!empty($valeur))
                <div class="champ"><strong>{{ ucfirst(str_replace('_', ' ', $code)) }} :</strong> {{ $valeur }}</div>
            @endif
        @endforeach
    @endif

    <!-- Lignes -->
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Description</th>
                <th>Qté</th>
                <th>P.U. (DH)</th>
                <th>Total (DH)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture->lignes as $ligne)
                <tr>
                    <td>{{ $ligne['plat'] ?? '' }}</td>
                    <td>{{ $ligne['designation'] ?? '' }}</td>
                    <td>{{ $ligne['quantite'] ?? 1 }}</td>
                    <td>{{ number_format($ligne['prix_unitaire'] ?? 0, 2) }}</td>
                    <td>{{ number_format(($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totaux -->
    <div class="totals">
        <div>Total HT : {{ number_format($facture->total_ht, 2) }} DH</div>
        @if($facture->tva_applicable)
            <div>TVA (20%) : {{ number_format($facture->tva, 2) }} DH</div>
        @endif
        <div style="font-size:13px;">Total TTC : {{ number_format($facture->total_ttc, 2) }} DH</div>
    </div>
</body>
</html>