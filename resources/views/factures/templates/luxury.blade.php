<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $facture->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            color: #333;
        }
        
        .invoice-wrapper {
            width: 210mm;
            height: 297mm;
            background: white;
            margin: 20px auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .invoice-container {
            padding: 20mm;
            font-size: 11px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        /* ========== TEMPLATE 1: PREMIUM ========== */
        .template-premium .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15mm;
            padding-bottom: 10mm;
            border-bottom: 3px solid #3498db;
        }
        
        .template-premium .company {
            flex: 1;
        }
        
        .template-premium .company-name {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 3px;
        }
        
        .template-premium .company-tag {
            font-size: 10px;
            color: #3498db;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .template-premium .invoice-title {
            text-align: right;
        }
        
        .template-premium .invoice-title h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 5px;
        }
        
        .template-premium .meta {
            font-size: 10px;
            color: #666;
            text-align: right;
        }
        
        .template-premium .meta div {
            margin: 2px 0;
        }
        
        .template-premium .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12mm;
            margin: 12mm 0;
        }
        
        .template-premium .party {
            background: linear-gradient(135deg, #ecf0f1 0%, #f8f9fa 100%);
            padding: 8mm;
            border-radius: 6px;
            border-left: 4px solid #3498db;
        }
        
        .template-premium .party strong {
            display: block;
            color: #1a202c;
            margin-bottom: 5mm;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
        }
        
        .template-premium .party p {
            margin: 2px 0;
            font-size: 10px;
            line-height: 1.6;
            color: #333;
        }
        
        .template-premium table {
            width: 100%;
            border-collapse: collapse;
            margin: 10mm 0;
            flex-grow: 1;
        }
        
        .template-premium thead {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        
        .template-premium th {
            padding: 6mm 4mm;
            text-align: left;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .template-premium td {
            padding: 5mm 4mm;
            border-bottom: 1px solid #ecf0f1;
            font-size: 10px;
        }
        
        .template-premium tbody tr:hover {
            background: #f8f9fa;
        }
        
        .template-premium .totals {
            display: flex;
            justify-content: flex-end;
            margin-top: 10mm;
            gap: 10mm;
        }
        
        .template-premium .totals-box {
            width: 140mm;
        }
        
        .template-premium .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5mm 0;
            border-bottom: 1px solid #ecf0f1;
            font-size: 10px;
        }
        
        .template-premium .total-row.final {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            font-weight: 700;
            padding: 7mm;
            border-radius: 5px;
            border: none;
            margin-top: 3mm;
            font-size: 11px;
        }
        
        /* ========== TEMPLATE 2: MINIMALISTE ========== */
        .template-minimal .header {
            margin-bottom: 12mm;
            padding-bottom: 8mm;
            border-bottom: 1px solid #ddd;
        }
        
        .template-minimal .header-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8mm;
        }
        
        .template-minimal .company-name {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
        }
        
        .template-minimal .invoice-number {
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .template-minimal .invoice-number strong {
            display: block;
            font-size: 14px;
            color: #1a202c;
            font-weight: 700;
        }
        
        .template-minimal .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15mm;
            margin: 10mm 0;
        }
        
        .template-minimal .party {
            font-size: 10px;
        }
        
        .template-minimal .party strong {
            display: block;
            margin-bottom: 4mm;
            color: #1a202c;
            font-weight: 700;
            font-size: 11px;
        }
        
        .template-minimal .party p {
            margin: 1px 0;
            color: #666;
            line-height: 1.5;
        }
        
        .template-minimal table {
            width: 100%;
            border-collapse: collapse;
            margin: 10mm 0;
            flex-grow: 1;
        }
        
        .template-minimal th {
            background: none;
            border-bottom: 2px solid #1a202c;
            padding: 5mm 4mm;
            text-align: left;
            font-weight: 700;
            font-size: 10px;
        }
        
        .template-minimal td {
            padding: 5mm 4mm;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .template-minimal tbody tr:last-child td {
            border-bottom: 2px solid #1a202c;
        }
        
        .template-minimal .totals {
            margin-top: 8mm;
            text-align: right;
        }
        
        .template-minimal .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 20mm;
            margin: 3mm 0;
            font-size: 10px;
        }
        
        .template-minimal .total-row.final {
            font-weight: 700;
            font-size: 11px;
            border-top: 2px solid #1a202c;
            padding-top: 5mm;
            margin-top: 5mm;
        }
        
        /* ========== TEMPLATE 3: CRÉATIF ========== */
        .template-creative {
            background: linear-gradient(to right, #f8f9fa 0%, white 20%, white 80%, #f8f9fa 100%);
        }
        
        .template-creative .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12mm;
            padding: 10mm;
            background: white;
            border-radius: 8px;
            border: 2px solid #e74c3c;
        }
        
        .template-creative .company {
            flex: 1;
        }
        
        .template-creative .company-name {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 2px;
        }
        
        .template-creative .company-tag {
            font-size: 9px;
            color: #666;
        }
        
        .template-creative .badge {
            background: #e74c3c;
            color: white;
            padding: 8mm 12mm;
            border-radius: 25px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
        }
        
        .template-creative .badge-number {
            display: block;
            font-size: 14px;
            margin-bottom: 1mm;
        }
        
        .template-creative .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10mm;
            margin: 10mm 0;
            background: white;
            padding: 8mm;
            border-radius: 6px;
        }
        
        .template-creative .party {
            font-size: 10px;
        }
        
        .template-creative .party strong {
            display: block;
            color: #e74c3c;
            margin-bottom: 4mm;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .template-creative .party p {
            margin: 2px 0;
            color: #333;
            line-height: 1.6;
        }
        
        .template-creative table {
            width: 100%;
            border-collapse: collapse;
            margin: 10mm 0;
            flex-grow: 1;
        }
        
        .template-creative thead {
            background: #e74c3c;
            color: white;
        }
        
        .template-creative th {
            padding: 6mm 4mm;
            text-align: left;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        .template-creative td {
            padding: 5mm 4mm;
            border-bottom: 1px solid #ecf0f1;
            font-size: 10px;
            background: white;
        }
        
        .template-creative tbody tr:nth-child(even) td {
            background: #f8f9fa;
        }
        
        .template-creative .totals {
            display: flex;
            justify-content: flex-end;
            margin-top: 10mm;
            gap: 10mm;
        }
        
        .template-creative .totals-box {
            background: white;
            padding: 8mm;
            border-radius: 6px;
            min-width: 120mm;
        }
        
        .template-creative .total-row {
            display: flex;
            justify-content: space-between;
            padding: 4mm 0;
            font-size: 10px;
            border-bottom: 1px solid #ecf0f1;
        }
        
        .template-creative .total-row.final {
            background: #e74c3c;
            color: white;
            font-weight: 700;
            padding: 6mm;
            border-radius: 4px;
            border: none;
            margin-top: 4mm;
            font-size: 11px;
        }
        
        /* Utilitaires */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .footer {
            text-align: center;
            font-size: 9px;
            color: #999;
            padding-top: 8mm;
            border-top: 1px solid #ddd;
            margin-top: auto;
        }
        
        @media print {
            body { background: white; }
            .invoice-wrapper { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>
    <!-- ========== TEMPLATE 1: PREMIUM ========== -->
    <div class="invoice-wrapper">
        <div class="invoice-container template-premium">
            <div class="header">
                <div class="company">
                    @if($facture->user->emetteur?->logo_path)
                        <img src="{{ public_path('storage/logos/' . $facture->user->emetteur->logo_path) }}" alt="Logo" style="height: 30px; margin-bottom: 8px;">
                    @endif
                    <div class="company-name">{{ $facture->user->emetteur?->nom_entreprise ?? config('app.name') }}</div>
                    <div class="company-tag">Services Professionnels</div>
                </div>
                <div class="invoice-title">
                    <h1>FACTURE</h1>
                    <div class="meta">
                        <div><strong>N° {{ $facture->numero ?? $facture->id }}</strong></div>
                        <div>{{ $facture->date_emission?->format('d/m/Y') ?? $facture->created_at->format('d/m/Y') }}</div>
                        @if($facture->date_echeance)
                            <div>Échéance: {{ $facture->date_echeance->format('d/m/Y') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="parties">
                <div class="party">
                    <strong>Émetteur</strong>
                    <p>{{ $facture->user->emetteur?->nom_entreprise ?? '–' }}</p>
                    @if($facture->user->emetteur?->adresse)
                        <p>{{ $facture->user->emetteur->adresse }}</p>
                    @endif
                    @if($facture->user->emetteur?->code_postal || $facture->user->emetteur?->ville)
                        <p>{{ $facture->user->emetteur?->code_postal ?? '' }} {{ $facture->user->emetteur?->ville ?? '' }}</p>
                    @endif
                    @if($facture->user->emetteur?->telephone)
                        <p>{{ $facture->user->emetteur->telephone }}</p>
                    @endif
                </div>
                <div class="party">
                    <strong>Client</strong>
                    <p>{{ $facture->client_nom ?? '–' }}</p>
                    @if($facture->client_adresse)
                        <p>{{ $facture->client_adresse }}</p>
                    @endif
                    @if($facture->client_ice)
                        <p>ICE: {{ $facture->client_ice }}</p>
                    @endif
                    @if($facture->client_tel)
                        <p>{{ $facture->client_tel }}</p>
                    @endif
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Désignation</th>
                        <th style="width: 10%; text-align: center;">Quantité</th>
                        <th style="width: 20%; text-align: right;">Prix Unitaire</th>
                        <th style="width: 20%; text-align: right;">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facture->lignes as $ligne)
                        <tr>
                            <td>
                                <strong>{{ $ligne['plat'] ?? $ligne['designation'] ?? '–' }}</strong>
                                @if($ligne['description'] ?? null)
                                    <br><span style="color: #999; font-size: 9px;">{{ $ligne['description'] }}</span>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $ligne['quantite'] ?? 1 }}</td>
                            <td class="text-right">{{ number_format($ligne['prix_unitaire'] ?? 0, 2, ',', ' ') }} {{ $facture->devise ?? 'DH' }}</td>
                            <td class="text-right"><strong>{{ number_format(($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0), 2, ',', ' ') }} {{ $facture->devise ?? 'DH' }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999; padding: 8mm;">Aucun article</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="totals">
                <div class="totals-box">
                    <div class="total-row">
                        <span><strong>Total HT</strong></span>
                        <span><strong>{{ number_format($facture->total_ht ?? 0, 2, ',', ' ') }} {{ $facture->devise ?? 'DH' }}</strong></span>
                    </div>
                    @if($facture->tva_applicable)
                        <div class="total-row">
                            <span>TVA (20%)</span>
                            <span>{{ number_format($facture->tva ?? 0, 2, ',', ' ') }} {{ $facture->devise ?? 'DH' }}</span>
                        </div>
                    @endif
                    <div class="total-row final">
                        <span>TOTAL TTC</span>
                        <span>{{ number_format($facture->total_ttc ?? 0, 2, ',', ' ') }} {{ $facture->devise ?? 'DH' }}</span>
                    </div>
                </div>
            </div>

            <div class="footer">
                Merci de votre confiance
            </div>
        </div>
    </div>
</body>
</html>