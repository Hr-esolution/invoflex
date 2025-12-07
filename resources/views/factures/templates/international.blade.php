<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; color: #333; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .info-block { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f9f9f9; }
        .totals { margin-top: 20px; text-align: right; }
        .totals div { margin: 5px 0; font-weight: bold; }
        .bank-info { margin-top: 20px; padding: 10px; background: #f5f5f5; border-radius: 4px; font-size: 9px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE</h2>
        <p>Invoice #{{ $facture->id }} — {{ $facture->created_at->format('Y-m-d') }}</p>
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
    <div class="info-grid">
        <div>
            <strong>From:</strong><br>
            Your Company Name<br>
            Address Line 1<br>
            City, Country<br>
            VAT: {{ $facture->valeurs_champs['vat_number'] ?? 'N/A' }}
        </div>
        <div>
            <strong>To:</strong><br>
            {{ $facture->client_nom }}<br>
            {{ $facture->client_adresse ?? 'N/A' }}<br>
            {{ $facture->client_tel ?? '' }}<br>
            Tax ID: {{ $facture->valeurs_champs['tax_id'] ?? 'N/A' }}
        </div>
    </div>

    <!-- Champs bancaires si disponibles -->
    @if(isset($facture->valeurs_champs['iban']) || isset($facture->valeurs_champs['swift']))
        <div class="bank-info">
            <strong>Bank Details:</strong><br>
            IBAN: {{ $facture->valeurs_champs['iban'] ?? 'N/A' }}<br>
            SWIFT/BIC: {{ $facture->valeurs_champs['swift'] ?? 'N/A' }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
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

    <div class="totals">
        <div>Subtotal: {{ number_format($facture->total_ht, 2) }} {{ $facture->valeurs_champs['devise'] ?? 'EUR' }}</div>
        @if($facture->tva_applicable)
            <div>Tax (20%): {{ number_format($facture->tva, 2) }} {{ $facture->valeurs_champs['devise'] ?? 'EUR' }}</div>
        @endif
        <div style="font-size:12px;">TOTAL: {{ number_format($facture->total_ttc, 2) }} {{ $facture->valeurs_champs['devise'] ?? 'EUR' }}</div>
    </div>
</body>
</html>