<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        body { font-family: 'Montserrat', sans-serif; margin: 0; padding: 20px; background: #f8f9fa; }
        .theme-invoice-3 { background: white; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.05); }
        .invoice-header { padding: 25px; border-bottom: 1px solid #eee; }
        .invoice-header ul { list-style: none; padding: 0; display: flex; justify-content: space-between; }
        .invoice-header li { display: flex; align-items: center; gap: 8px; }
        .invoice-body { padding: 25px; }
        .address-detail h2 { margin: 0 0 15px; font-size: 24px; text-transform: uppercase; }
        .date-detail { list-style: none; padding: 0; }
        .date-detail li { margin: 6px 0; }
        .date-detail span { font-weight: 600; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-weight: 600; }
        tfoot td { font-weight: 600; }
        .text-theme { color: #000; }
        .btn { padding: 8px 20px; border-radius: 4px; text-decoration: none; margin: 5px; }
        .btn-solid { background: #000; color: white; }
        .black-btn { background: #333; color: white; }
    </style>
</head>
<body>
    <section class="theme-invoice-3">
        <div class="invoice-wrapper">
            <div class="invoice-header">
                <ul>
                    <li>
                        @if($facture->user->emetteur?->logo_path)
                            <img src="{{ public_path('storage/logos/' . $facture->user->emetteur->logo_path) }}" 
                                 alt="Logo" style="max-height:40px;">
                        @else
                            <h4>{{ $facture->user->emetteur?->nom_entreprise ?? config('app.name') }}</h4>
                        @endif
                    </li>
                    <li>
                        <i class="ri-map-pin-2-fill"></i>
                        <div>
                            <h4>{{ $facture->user->emetteur?->adresse ?? '' }}</h4>
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
            <div class="invoice-body">
                <div class="top-sec" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                    <div class="address-detail">
                        <h2>FACTURE</h2>
                        <div class="mt-3">
                            <h4 class="mb-2">{{ $facture->client_nom }}</h4>
                            <h4 class="mb-0">{{ $facture->client_adresse ?? '' }}</h4>
                        </div>
                    </div>
                    <div class="mt-md-0 mt-2">
                        <ul class="date-detail">
                            <li><span>Date :</span> {{ $facture->created_at->format('d/m/Y') }}</li>
                            <li><span>N° :</span> {{ $facture->id }}</li>
                            <li><span>Email :</span> {{ $facture->client_email ?? '–' }}</li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive-md">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produit</th>
                                <th>P.U.</th>
                                <th>Qté</th>
                                <th>Total</th>
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
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td class="font-bold text-dark">TOTAL</td>
                                <td class="font-bold text-theme">{{ number_format($facture->total_ttc, 2) }} DH</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>