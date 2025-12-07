<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/..._create_facture_champs_table.php
public function up()
{
    Schema::create('facture_champs', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->string('nom_fr');
        $table->string('nom_en')->nullable();
        $table->string('type')->default('text'); // text, number, date, boolean
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_champs');
    }
};
