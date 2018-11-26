<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAvocatProcureur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avocat_procureur', function (Blueprint $table) {
            $table->integer('id_procureur')->unsigned()->nullable();
            $table->integer('id_avocat')->unsigned()->nullable();
            $table->foreign('id_procureur')->references('id_procureur')->on('procureurs')->onDelete('cascade');
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
        Schema::dropIfExists('avocat_procureur');
    }
}
