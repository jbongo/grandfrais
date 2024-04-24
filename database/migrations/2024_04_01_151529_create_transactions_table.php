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

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // achat, vente, depense, depot, retrait         
            $table->string('operation')->nullable();
            // debit ou credit   
            $table->string('type')->nullable();
            $table->date('date_transaction')->nullable();
            $table->double('montant')->nullable();
            $table->text('description')->nullable();
            $table->integer('caisse_id')->nullable();
            $table->integer('user_id')->nullable();
            // achat_id, vente_id, depense_id
            $table->integer('resource_id')->nullable();   
            $table->double('solde')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};