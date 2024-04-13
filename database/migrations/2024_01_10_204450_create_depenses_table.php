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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            // Transport - Nourriture - Logement - Autre - fixe
            $table->integer('typedepense_id')->nullable();
            $table->text('details')->nullable();
            $table->double('montant')->nullable();          
            $table->date('date_depense')->nullable();
            $table->integer('caisse_id')->nullable();
            $table->boolean('archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};