<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConvocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocations', function (Blueprint $table) {
            $table->increments('id_convocation');
            $table->timestamp('date_convocation');
            $table->string('heure_convocation');
            $table->integer('num_jugement')->unsigned()->nullable();
            $table->foreign('num_jugement')->references('num_jugement')->on('jugements');
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
        Schema::dropIfExists('convocations');
    }
}
