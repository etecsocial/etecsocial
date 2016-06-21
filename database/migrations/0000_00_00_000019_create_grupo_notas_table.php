<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoNotasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_notas')) {
            Schema::create('grupo_notas', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nota', 200);
                $table->integer('id_prof')->unsigned();
                $table->integer('id_grupo')->unsigned();

//                $table->foreign('id_grupo')->references('id')->on('grupo');
//                $table->foreign('id_prof')->references('id')->on('users');

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
        Schema::dropIfExists('grupo_notas');
    }

}
