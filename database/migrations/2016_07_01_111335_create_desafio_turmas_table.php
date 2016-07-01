<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesafioTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desafio_turmas', function (Blueprint $table) {
          $table->integer('desafio_id')->unsigned();
          $table->integer('turma_id')->unsigned();

          $table->foreign('desafio_id')
                  ->references('id')
                  ->on('desafios')
                  ->onDelete('cascade');

          $table->foreign('turma_id')
                  ->references('id')
                  ->on('turmas')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('desafio_turmas');
    }
}
