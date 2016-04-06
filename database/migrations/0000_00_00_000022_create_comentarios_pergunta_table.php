<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosPerguntaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('comentarios_pergunta')) {
        Schema::create('comentarios_pergunta', function(Blueprint $table) {
            $table->increments('id');
            $table->string('comentario', 300);

            $table->integer('id_user')->unsigned();
            $table->integer('id_pergunta')->unsigned();
            $table->integer('id_grupo')->unsigned();

            $table->foreign('id_grupo')->references('id')->on('grupo');
            $table->foreign('id_pergunta')->references('id')->on('grupo_pergunta');
            $table->foreign('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('comentarios_pergunta');
    }

}
