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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("reference")->nullable();
            
            $table->integer("fournisseur_id")->nullable();
            $table->integer("produit_id")->nullable();
            $table->integer("marque_id")->nullable();
            $table->integer("user_id")->nullable();
            $table->integer("tva_id")->nullable();
            // Simple, déclinaison
            $table->string("type")->nullable();
            // Matériel, Prestation de service
            $table->string("nature")->nullable();
            $table->boolean("a_declinaison")->default(false);
            $table->text("description")->nullable();
            $table->string("fiche_technique")->nullable();
            $table->double("prix_achat_ht")->nullable();
            $table->double("prix_achat_ttc")->nullable();  
            $table->double("prix_vente_ht")->nullable();
            $table->double("prix_vente_ttc")->nullable();
            
            // stock
            $table->boolean("gerer_stock")->default(false);
            $table->string("unite_mesure_stock")->nullable();
            $table->double("quantite_stock")->nullable();
            $table->double("seuil_alerte_stock")->nullable();
            $table->boolean("archive")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};