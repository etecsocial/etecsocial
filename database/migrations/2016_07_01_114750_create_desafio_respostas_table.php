<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesafioRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desafio_respostas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('desafio_id')->unsigned();
            $table->integer('aluno_id')->unsigned();
            $table->text('resposta');
            $table->text('resposta_comentario');
            $table->boolean('corrigida')->default(false);
            $table->boolean('correto')->default(false);


            $table->foreign('desafio_id')
                    ->references('id')
                    ->on('desafios')
                    ->onDelete('cascade');

            $table->foreign('aluno_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');


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
        Schema::drop('desafio_respostas');
    }
}
