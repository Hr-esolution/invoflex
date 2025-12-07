<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up()
{
    Schema::create('facture_templates', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->string('nom_fr');
        $table->string('nom_en')->nullable();
        $table->string('chemin_blade');
        $table->boolean('actif')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_templates');
    }
};
