<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunicadosCoord extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('comunicados_coord', function(Blueprint $table) {
            $table->integer('id', 11)->unsigned();
            $table->string('id_etec')->references('id_etec')->on('lista_etecs');
            $table->integer('titulo');
            $table->date('comunicado');
            $table->date('visualizacoes');
            $table->integer('id_autor')->referencer('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('comunicados_coord');
    }

}
