<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FactureTemplate;
use App\Models\FactureChamp;

class FacturationSeeder extends Seeder
{
    public function run()
    {
        // Templates
        FactureTemplate::upsert([
            ['code' => 'standard', 'nom_fr' => 'Standard', 'chemin_blade' => 'factures.templates.standard'],
            ['code' => 'restaurant', 'nom_fr' => 'Restaurant', 'chemin_blade' => 'factures.templates.restaurant'],
            ['code' => 'international', 'nom_fr' => 'International', 'chemin_blade' => 'factures.templates.international'],
        ], ['code']);

        // Champs internationaux
        $champs = [
            ['code' => 'ice', 'nom_fr' => 'ICE (Maroc)', 'type' => 'text'],
            ['code' => 'cif', 'nom_fr' => 'CIF (Espagne)', 'type' => 'text'],
            ['code' => 'siret', 'nom_fr' => 'SIRET (France)', 'type' => 'text'],
            ['code' => 'vat_number', 'nom_fr' => 'Numéro de TVA (UE)', 'type' => 'text'],
            ['code' => 'tax_id', 'nom_fr' => 'ID Fiscal', 'type' => 'text'],
            ['code' => 'iban', 'nom_fr' => 'IBAN', 'type' => 'text'],
            ['code' => 'swift', 'nom_fr' => 'SWIFT/BIC', 'type' => 'text'],
            ['code' => 'client_email', 'nom_fr' => 'Email client', 'type' => 'text'],
            ['code' => 'date_echeance', 'nom_fr' => 'Date d\'échéance', 'type' => 'date'],
            ['code' => 'note', 'nom_fr' => 'Note personnalisée', 'type' => 'text'],
            ['code' => 'num_commande', 'nom_fr' => 'N° commande', 'type' => 'text'],
        ];

        foreach ($champs as $champ) {
            FactureChamp::updateOrCreate(['code' => $champ['code']], $champ);
        }
    }
}