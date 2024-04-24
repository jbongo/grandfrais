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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->integer('produit_id')->nullable();
            $table->integer('fournisseur_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('caisse_id')->nullable();
            $table->double('quantite')->nullable(); 
            $table->double('prix_unitaire')->nullable();
            $table->double('prix_total')->nullable();
            $table->date('date_achat')->nullable();
            $table->string('statut')->nullable();
            $table->string('archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achats');
    }
};