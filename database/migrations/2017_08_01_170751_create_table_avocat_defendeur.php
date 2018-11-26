<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAvocatDefendeur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avocat_defendeur', function (Blueprint $table) {
            $table->integer('id_defendeur')->unsigned();
            $table->integer('id_avocat')->unsigned();
            $table->foreign('id_defendeur')->references('id_defendeur')->on('defendeurs')->onDelete('cascade');
            $table->foreign('id_avocat')->references('id_avocat')->on('avocats')->onDelete('cascade');
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
        Schema::dropIfExists('avocat_defendeur');
    }
}
