<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJugement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugements', function (Blueprint $table) {
            $table->integer('num_Jugement')->primary()->unsigned();
            $table->integer('nbr_procureur')->unsigned();
            $table->integer('nbr_defendeur')->unsigned();
            $table->integer('nbr_autre')->unsigned();
            $table->timestamp('date_jugement');
            $table->text('raison_jugement');
            $table->string('nom_juge');
            $table->bigInteger('num_dossier')->unsigned()->nullable();
            $table->integer('id_tribunal')->unsigned()->nullable();
            $table->foreign('num_dossier')->references('num_dossier')->on('dossiers');
            $table->foreign('id_tribunal')->references('id_tribunal')->on('tribunals');
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
        Schema::dropIfExists('jugements');
    }
}
