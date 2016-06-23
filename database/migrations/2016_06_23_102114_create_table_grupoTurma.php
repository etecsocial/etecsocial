<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrupoTurma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_turma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_grupo');
            $table->integer('id_turma');
            $table->tinyInteger('modulo');
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
        Schema::drop('grupo_turma');
    }
}
