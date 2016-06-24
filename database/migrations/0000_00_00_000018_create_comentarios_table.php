<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('comentarios')) {
            Schema::create('comentarios', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('id_post')->unsigned();
                $table->string('comentario');
                $table->integer('relevancia')->nullable();
                $table->timestamps();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('id_post')
                        ->references('id')
                        ->on('posts')
                        ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('comentarios');
    }

}
