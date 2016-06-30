<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelevanciaComentariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('relevancia_comentarios')) {
            Schema::create('relevancia_comentarios', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable()->unsigned();
                $table->integer('comentario_id')->nullable()->unsigned();
                $table->integer('discussao_id')->nullable()->unsigned();
                $table->integer('id_pergunta')->nullable()->unsigned();
                $table->string('relevancia', 4);
                $table->timestamps();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('comentario_id')
                        ->references('id')
                        ->on('comentarios')
                        ->onDelete('cascade');
                
                $table->foreign('discussao_id')
                        ->references('id')
                        ->on('grupo_discussao')
                        ->onDelete('cascade');
                
                $table->foreign('id_pergunta')
                        ->references('id')
                        ->on('grupo_pergunta')
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
        Schema::dropIfExists('relevancia_comentarios');
    }

}
