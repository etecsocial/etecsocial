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
            
            //Mais a frente, conferir a relação n pra n
            
            Schema::create('comentarios_discussao', function(Blueprint $table) {
                $table->increments('id');
                $table->string('comentario', 1000);

                $table->integer('discussao_id')->unsigned();
                $table->integer('grupo_id')->unsigned();
                $table->integer('user_id')->unsigned();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('discussao_id')
                        ->references('id')
                        ->on('grupo_discussao')
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
        Schema::dropIfExists('comentarios_discussao');
    }

}
