<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoMaterialTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_material')) {
            Schema::create('grupo_material', function(Blueprint $table) {
                $table->increments('id');
                $table->string('tipo', 15);
                $table->string('nome', 50);
                $table->string('caminho', 100);
                $table->integer('id_autor')->unsigned();
                $table->integer('id_grupo')->unsigned();

//                $table->foreign('id_grupo')->references('id')->on('grupo');
//                $table->foreign('id_autor')->references('id')->on('users');

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
        Schema::dropIfExists('grupo_material');
    }

}
