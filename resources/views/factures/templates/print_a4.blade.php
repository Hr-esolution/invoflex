<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        @page {
            size: A4;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: white;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11px;
        }

        .invoice-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
        }

        /* Reste du CSS identique */
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15mm;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10mm;
        }

        .company-info img {
            height: 30px;
            margin-bottom: 5px;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
        }

        .company-label {
            font-size: 9px;
            color: #7f8c8d;
            text-transform: uppercase;
            font-weight: 600;
            margin-top: 2px;
        }

        .invoice-header-right {
            text-align: right;
        }

        .invoice-header-right h1 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-meta-data {
            font-size: 10px;
            color: #666;
        }

        .invoice-meta-data div {
            margin: 3px 0;
        }

        .parties-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15mm;
            margin-bottom: 10mm;
        }

        .partie-block {
            background: #f9fafb;
            padding: 8mm;
            border-radius: 4px;
            border-left: 3px solid #2c3e50;
        }

        .partie-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1a202c;
            margin-bottom: 5mm;
            padding-bottom: 3mm;
            border-bottom: 1px solid #ddd;
        }

        .partie-content {
            font-size: 10px;
            line-height: 1.7;
            color: #333;
        }

        .partie-content .name {
            font-weight: 700;
            margin-bottom: 3px;
            color: #1a202c;
        }

        .partie-content .line {
            margin: 2px 0;
            min-height: 12px;
        }

        .items-table {
            width: 100%;
            margin: 10mm 0;
            border-collapse: collapse;
            font-size: 10px;
        }

        .items-table thead {
            background: #2c3e50;
            color: white;
        }

        .items-table th {
            padding: 6mm 3mm;
            text-align: left;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 5mm 3mm;
            border-bottom: 1px solid #ecf0f1;
        }

        .items-table tr:last-child td {
            border-bottom: 2px solid #2c3e50;
        }

        .items-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 10mm;
            margin-bottom: 8mm;
        }

        .totals-box {
            width: 120mm;
            max-width: 100%;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 4mm 0;
            font-size: 10px;
            border-bottom: 1px solid #ddd;
        }

        .total-row.final {
            background: #2c3e50;
            color: white;
            font-weight: 700;
            font-size: 11px;
            padding: 6mm;
            border: none;
            border-radius: 3px;
            margin-top: 3mm;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            color: #999;
            padding-top: 8mm;
            border-top: 1px solid #ddd;
            margin-top: 8mm;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- En-tête -->
        <div class="header-top">
            <div class="company-info">
                @if($facture->user->emetteur?->logo_path)
                    <img src="{{ storage_path('app/public/logos/' . $facture->user->emetteur->logo_path) }}" alt="Logo">
                @endif
                <div class="company-name">{{ $facture->user->emetteur?->nom_entreprise ?? config('app.name') }}</div>
                <div class="company-label">Services Professionnels</div>
            </div>
            
            <div class="invoice-header-right">
                <h1>FACTURE</h1>
                <div class="invoice-meta-data">
                    <div><strong>N° {{ $facture->id }}</strong></div>
                    <div>Émise le : {{ $facture->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Émetteur et Client -->
        <div class="parties-section">
            <div class="partie-block">
                <div class="partie-title">Émetteur</div>
                <div class="partie-content">
                    <div class="name">{{ $facture->user->emetteur?->nom_entreprise ?? 'Société' }}</div>
                    <div class="line">{{ $facture->user->emetteur?->adresse ?? '' }}</div>
                    <div class="line">{{ $facture->user->emetteur?->code_postal ?? '' }} {{ $facture->user->emetteur?->ville ?? '' }}</div>
                    @if($facture->user->emetteur?->telephone)
                        <div class="line">Tél: {{ $facture->user->emetteur->telephone }}</div>
                    @endif
                    @if($facture->user->emetteur?->email)
                        <div class="line">Email: {{ $facture->user->emetteur->email }}</div>
                    @endif
                </div>
            </div>
            
            <div class="partie-block">
                <div class="partie-title">Client</div>
                <div class="partie-content">
                    <div class="name">{{ $facture->client_nom ?? '________________________' }}</div>
                    <div class="line">{{ $facture->client_adresse ?? '________________________' }}</div>
                    <div class="line">{{ $facture->client_tel ?? '________________________' }}</div>
                </div>
            </div>
        </div>

        <!-- Tableau des articles -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Désignation</th>
                    <th style="width: 10%; text-align: center;">Quantité</th>
                    <th style="width: 20%; text-align: right;">P.U.</th>
                    <th style="width: 20%; text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facture->lignes as $ligne)
                    <tr>
                        <td>
                            <strong>{{ $ligne['plat'] ?? $ligne['designation'] ?? '–' }}</strong>
                            @if(isset($ligne['description']) && $ligne['description'])
                                <br><span style="color: #999; font-size: 9px;">{{ $ligne['description'] }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $ligne['quantite'] ?? 1 }}</td>
                        <td class="text-right">{{ number_format($ligne['prix_unitaire'] ?? 0, 2, ',', ' ') }} DH</td>
                        <td class="text-right"><strong>{{ number_format(($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0), 2, ',', ' ') }} DH</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding: 10mm; color: #999;">Aucun article</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span class="total-label">Montant HT</span>
                    <span class="total-value">{{ number_format($facture->total_ht, 2, ',', ' ') }} DH</span>
                </div>
                @if($facture->tva_applicable)
                    <div class="total-row">
                        <span class="total-label">TVA (20%)</span>
                        <span class="total-value">{{ number_format($facture->tva, 2, ',', ' ') }} DH</span>
                    </div>
                @endif
                <div class="total-row final">
                    <span class="total-label">TOTAL TTC</span>
                    <span class="total-value">{{ number_format($facture->total_ttc, 2, ',', ' ') }} DH</span>
                </div>
            </div>
        </div>

        <div class="footer">
            Merci de votre confiance - Document généré automatiquement
        </div>
    </div>
</body>
</html>