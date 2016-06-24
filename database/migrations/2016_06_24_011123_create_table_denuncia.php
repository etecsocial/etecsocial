<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDenuncia extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('denuncia', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('mensagem_id')->unsigned();
            $table->date('data');
            $table->string('texto', 50);
            $table->string('tipo', 10);
            $table->integer('excluir');
            $table->integer('num_avaliacoes');

            $table->foreign('mensagem_id')
                    ->references('id')
                    ->on('mensagens')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('denuncia');
    }

}
