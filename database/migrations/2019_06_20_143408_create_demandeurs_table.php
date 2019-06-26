<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandeurs', function (Blueprint $table) {
            $table->integer('demandeur_id')->autoIncrement();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin')->unique();
            $table->string('nationalite')->nullable();
            $table->string('ville')->nullable();
            $table->string('adresse')->nullable();
            $table->string('zip')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('type')->default('demandeur');
            $table->string('mdp');
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
        Schema::dropIfExists('demandeurs');
    }
}
