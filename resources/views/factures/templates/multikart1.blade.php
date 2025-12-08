<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap');

        /* Bootstrap + Custom CSS inlined */
        body { font-family: 'Montserrat', sans-serif; background: #f8f9fa; margin: 0; padding: 20px; }
        .theme-invoice-4 { background: white; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.05); overflow: hidden; }
        .invoice-header { position: relative; text-align: center; padding: 30px 0; }
        .invoice-header img { max-width: 120px; }
        .invoice-body { padding: 30px; }
        .address-detail h4 { margin: 4px 0; font-weight: 500; }
        .date-detail { list-style: none; padding: 0; margin: 0; }
        .date-detail li { margin: 6px 0; }
        .date-detail span { font-weight: 600; color: #555; }
        .title { text-align: center; font-size: 28px; margin: 20px 0; text-transform: uppercase; color: #333; }
        .btn { padding: 8px 20px; border-radius: 4px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-solid { background: #000; color: white; }
        .black-btn { background: #333; color: white; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        .table-footer { margin-top: 20px; font-size: 18px; font-weight: 700; }
        .invoice-footer { background: #333; color: white; padding: 30px; text-align: center; }
        .invoice-footer ul { list-style: none; padding: 0; display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; }
        .invoice-footer li { display: flex; align-items: center; gap: 10px; }
        .invoice-footer i { font-size: 20px; }
    </style>
</head>
<body>
    <section class="theme-invoice-4">
        <div class="invoice-wrapper">
            <div class="invoice-header">
                {{-- Logo optionnel --}}
                @if($facture->user->emetteur?->logo_path)
                    <img src="{{ public_path('storage/logos/' . $facture->user->emetteur->logo_path) }}" 
                         alt="Logo" style="max-height:60px; max-width:150px;">
                @else
                    <h3>{{ $facture->user->emetteur?->nom_entreprise ?? config('app.name') }}</h3>
                @endif
            </div>
            <div class="invoice-body">
                <div class="top-sec">
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div class="address-detail">
                            @if($facture->user->emetteur)
                                <h4 class="mb-2">{{ $facture->user->emetteur->adresse ?? '' }}</h4>
                                <h4 class="mb-2">{{ $facture->user->emetteur->ville ?? '' }} {{ $facture->user->emetteur->code_postal ?? '' }}</h4>
                                <h4 class="mb-0">{{ $facture->user->emetteur->pays ?? 'Maroc' }}</h4>
                            @endif
                        </div>
                        <div>
                            <ul class="date-detail">
                                <li><span>Date :</span> {{ $facture->created_at->format('d/m/Y') }}</li>
                                <li><span>N° facture :</span> {{ $facture->id }}</li>
                                <li><span>Email :</span> {{ $facture->client_email ?? $facture->user->email }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="title-sec">
                    <h2 class="title">FACTURE</h2>
                </div>
                <div class="table-sec">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produit</th>
                                <th>P.U. (DH)</th>
                                <th>Qté</th>
                                <th>Total (DH)</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($facture->lignes as $ligne)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $ligne['plat'] ?? '–' }}</td>
    <td>{{ number_format($ligne['prix_unitaire'] ?? 0, 2) }}</td>
    <td>{{ $ligne['quantite'] ?? 1 }}</td>
    <td>{{ number_format(($ligne['quantite'] ?? 1) * ($ligne['prix_unitaire'] ?? 0), 2) }}</td>
</tr>
@endforeach
                        </tbody>
                    </table>
                    <div class="text-end">
                        <div class="table-footer">
                            <span class="me-5">Total TTC</span>
                            <span>{{ number_format($facture->total_ttc, 2) }} DH</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-footer">
                <ul>
                    <li>
                        <i class="fa fa-map"></i>
                        <div>
                            <h4>{{ $facture->user->emetteur?->nom_entreprise ?? 'Entreprise' }}</h4>
                            <h4>{{ $facture->user->emetteur?->telephone ?? '' }}</h4>
                        </div>
                    </li>
                    <li>
                        <i class="ri-mail-fill"></i>
                        <div>
                            <h4>{{ $facture->user->email }}</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</body>
</html>