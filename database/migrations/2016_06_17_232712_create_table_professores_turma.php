<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfessoresTurma extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('professores_turma')) {
            Schema::create('professores_turma', function(Blueprint $table) {
                $table->increments('id');

                $table->integer('user_id')->unsigned();
                $table->integer('modulo');
                $table->integer('turma_id')->unsigned();
                $table->timestamps();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
            
                $table->foreign('turma_id')
                        ->references('id')
                        ->on('turmas')
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
        Schema::dropIfExists('professores_turma');
    }

}
