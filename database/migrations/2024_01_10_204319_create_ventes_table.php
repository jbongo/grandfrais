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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('numero')->nullable();
            $table->integer('user_id')->nullable();            
            $table->date('date_vente')->nullable();
            $table->double('montant')->nullable();
            $table->double('benefice')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('ventes');
    }
};