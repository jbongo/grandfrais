<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // Le user qui a crée le contact
            $table->integer('user_id')->unsigned()->nullable();
            $table->string("type")->nullable();
            $table->string('civilite')->nullable();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string("entreprise")->nullable();
            $table->string("email")->nullable();
            $table->string('indicatif_1')->nullable();
            $table->string('indicatif_2')->nullable();
            $table->string('telephone_1')->nullable();
            $table->string('telephone_2')->nullable();
            $table->string('ville')->nullable();
            $table->string('quartier')->nullable();
            $table->text('notes')->nullable();
            $table->boolean("archive")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}