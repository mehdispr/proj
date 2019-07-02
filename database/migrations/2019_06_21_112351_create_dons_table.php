<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dons', function (Blueprint $table) {
            $table->integer('don_id')->autoIncrement();
            $table->integer('paiement_id');
            $table->integer('projet_id');
            $table->boolean('hide')->default(false);
            $table->foreign('projet_id')->references('projet_id')->on('projets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paiement_id')->references('paiement_id')->on('paiements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('dons');
    }
}
