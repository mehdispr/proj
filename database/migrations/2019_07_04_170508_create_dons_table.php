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
            $table->integer('donateur_id');
            $table->integer('projet_id');
            $table->boolean('hide')->default(false);
            $table->foreign('projet_id')->references('projet_id')->on('projets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('donateur_id')->references('donateur_id')->on('donateurs')->onDelete('cascade')->onUpdate('cascade');
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