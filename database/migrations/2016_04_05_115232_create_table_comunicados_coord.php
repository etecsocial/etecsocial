<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunicadosCoordTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('comunicados_coord')) {
            Schema::create('comunicados_coord', function(Blueprint $table) {
                $table->increments('id')->unique();
                $table->integer('id_coord');
                $table->foreign('id_coord')->references('id')->on('users');
                $table->integer('id_etec')->unsigned();
                $table->foreign('id_etec')->references('id_etec')->on('lista_etecs');
                $table->text('comunicado', 1000);
                $table->integer('id_pergunta')->nullable();
                $table->timestamps();
            });
        }
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
