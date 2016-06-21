<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosDiscussaoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('comentarios_discussao')) {
            Schema::create('comentarios_discussao', function(Blueprint $table) {
                $table->increments('id');
                $table->string('comentario', 1000);

                $table->integer('id_discussao')->unsigned();
                $table->integer('id_grupo')->unsigned();
                $table->integer('id_user')->unsigned();

//                $table->foreign('id_grupo')->references('id')->on('grupo');
//                $table->foreign('id_discussao')->references('id')->on('grupo_discussao');
//                $table->foreign('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('comentarios_discussao');
    }

}
