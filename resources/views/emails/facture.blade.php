@component('mail::message')
# Bonjour {{ $facture->client_nom }},

Veuillez trouver ci-joint votre facture **#{{ $facture->id }}**.

Merci de votre confiance !  
L'équipe **InvoFlex**

@component('mail::button', ['url' => route('factures.pdf', $facture->id)])
Voir la facture en ligne
@endcomponent
@endcomponent