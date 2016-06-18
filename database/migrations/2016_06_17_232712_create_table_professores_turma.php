<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfessoresTurma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('professores_turma')) {
            Schema::create('professores_turma', function(Blueprint $table) {
                $table->increments('id');
                
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->integer('id_turma')->unsigned();
                $table->foreign('id_turma')->references('id')->on('turmas')->onDelete('cascade');
                
                $table->integer('id_escola')->unsigned();
                $table->foreign('id_escola')->references('id')->on('escolas')->onDelete('cascade');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professores_turma');
    }
}
