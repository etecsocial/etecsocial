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

                $table->integer('user_id')->unsigned();
                $table->integer('id_pergunta')->unsigned();
                $table->integer('grupo_id')->unsigned();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('id_pergunta')
                        ->references('id')
                        ->on('grupo_pergunta')
                        ->onDelete('cascade');
                
                $table->foreign('grupo_id')
                        ->references('id')
                        ->on('grupo')
                        ->onDelete('cascade');

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
