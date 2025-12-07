<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Client
            $table->string('client_nom');
            $table->string('client_tel')->nullable();
            $table->string('client_adresse')->nullable();
            $table->string('client_ice')->nullable();

            // TVA
            $table->boolean('tva_applicable')->default(false);
            $table->decimal('total_ht', 12, 2);
            $table->decimal('tva', 12, 2)->default(0);
            $table->decimal('total_ttc', 12, 2);

            // Lignes de facture (produits)
            $table->json('lignes'); // [{ plat, designation, quantite, prix_unitaire, sous_total }]

            // Template et champs dynamiques
            $table->foreignId('template_id')->nullable()->constrained('facture_templates')->nullOnDelete();
            $table->json('valeurs_champs')->nullable(); // { "ice": "...", "iban": "..." }

            // PDF
            $table->string('pdf_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
};