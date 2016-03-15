<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRelevanciaComentarios extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relevancia_comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario');
            $table->integer('id_comentario');
            $table->integer('id_post')->nullable();
            $table->integer('id_discussao')->nullable();
            $table->integer('id_pergunta')->nullable();
            $table->string('relevancia', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relevancia_comentarios');
    }

}
