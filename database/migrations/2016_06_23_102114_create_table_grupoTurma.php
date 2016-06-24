<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrupoTurma extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('grupo_turma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo_id')->unsigned();
            $table->integer('turma_id')->unsigned();
            $table->tinyInteger('modulo');
            $table->timestamps();

            $table->foreign('grupo_id')
                    ->references('id')
                    ->on('grupo')
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
    public function down() {
        Schema::drop('grupo_turma');
    }

}
