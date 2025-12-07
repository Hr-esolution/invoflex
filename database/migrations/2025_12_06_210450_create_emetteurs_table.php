<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/..._create_emetteurs_table.php
public function up()
{
    Schema::create('emetteurs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nom_entreprise');
        $table->string('adresse')->nullable();
        $table->string('ville')->nullable();
        $table->string('code_postal')->nullable();
        $table->string('pays')->default('Maroc');
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->string('ice')->nullable();          // Maroc
        $table->string('rc')->nullable();           // Registre de Commerce
        $table->string('patente')->nullable();      // Maroc
        $table->string('cnss')->nullable();         // Affiliation
        $table->string('logo_path')->nullable();    // Si tu veux un logo
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emetteurs');
    }
};
