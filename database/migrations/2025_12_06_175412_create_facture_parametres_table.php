<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/..._create_facture_parametres_table.php
public function up()
{
    Schema::create('facture_parametres', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('template_defaut_id')->nullable()->constrained('facture_templates')->nullOnDelete();
        $table->json('champs_actifs')->nullable(); // ex: ["ice", "iban"]
        $table->string('mode_produit_defaut')->default('liste'); // 'liste' ou 'manuel'
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_parametres');
    }
};
