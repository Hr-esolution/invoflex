<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture Restaurant</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #4361ee; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4361ee; }
        .info-section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #eef2ff; }
        .totals { margin-top: 20px; text-align: right; }
        .totals div { margin: 6px 0; font-weight: bold; }
        .champ { margin: 4px 0; color: #555; }
        .footer { margin-top: 30px; font-size: 10px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RESTAURANT INVOFLEX</h2>
        <p>Facture N° {{ $facture->id }} — {{ $facture->created_at->format('d/m/Y H:i') }}</p>
    </div>
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
        <strong>Client :</strong> {{ $facture->client_nom }}
        @if($facture->client_tel) — Tél: {{ $facture->client_tel }} @endif
        @if($facture->valeurs_champs['num_commande'] ?? null)
            <br><strong>Commande :</strong> {{ $facture->valeurs_champs['num_commande'] }}
        @endif
        @if($facture->valeurs_champs['table'] ?? null)
            <br><strong>Table :</strong> {{ $facture->valeurs_champs['table'] }}
        @endif
    </div>

    <!-- Champs dynamiques utiles -->
    @if($facture->client_ice)
        <div class="champ"><strong>ICE :</strong> {{ $facture->client_ice }}</div>
    @endif
    @if($facture->valeurs_champs['note'] ?? null)
        <div class="champ"><strong>Note :</strong> {{ $facture->valeurs_champs['note'] }}</div>
    @endif

    <!-- Lignes -->
    <table>
        <thead>
            <tr>
                <th>Plat</th>
                <th>Description</th>
                <th>Qté</th>
                <th>Prix (DH)</th>
                <th>Total (DH)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture->lignes as $ligne)
                <tr>
                    <td><strong>{{ $ligne['plat'] ?? '' }}</strong></td>
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
        <div style="font-size:13px; color:#4361ee;">À PAYER : {{ number_format($facture->total_ttc, 2) }} DH</div>
    </div>

    <div class="footer">
        Merci de votre visite ! — Tél: 05 00 00 00 00 — www.invoflex.test
    </div>
</body>
</html>