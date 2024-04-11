<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produit_vente', function (Blueprint $table) {
            $table->id();
            $table->integer('produit_id')->nullable();
            $table->integer('vente_id')->nullable();
            $table->double('quantite')->nullable();
            $table->double('prix_unitaire')->nullable();
            $table->boolean('prix_unitaire_modifie')->default(false);
            $table->double('prix_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_vente');
    }
};