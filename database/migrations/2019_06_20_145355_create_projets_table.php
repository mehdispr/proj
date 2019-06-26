<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->integer('projet_id')->autoIncrement();
            $table->integer('demandeur_id');
            $table->integer('moderateur_id');
            $table->string('titre');
            $table->string('categorie')->in('sociale','sport','economie','maladie');
            $table->double('montant')->default(0);
            $table->double('restant')->nullable();
            $table->date('date_debut');
            $table->text('description');
            $table->integer('visited')->default(0);
            $table->foreign('demandeur_id')->references('demandeur_id')->on('demandeurs')->onDelete('cascade');
            $table->foreign('moderateur_id')->references('moderateur_id')->on('moderateurs');
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
        Schema::dropIfExists('projets');
    }
}
