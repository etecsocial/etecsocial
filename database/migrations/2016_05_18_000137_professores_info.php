<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfessoresInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('professores_info')) {
            Schema::create('professores_info', function(Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->integer('id_turma')->unsigned()->default(1);
                $table->foreign('id_turma')->references('id')->on('turmas');

                $table->integer('id_modulo')->unsigned()->default(1);
                $table->foreign('id_modulo')->references('id')->on('modulos');
                
                $table->integer('id_escola')->unsigned()->default(1);
                $table->foreign('id_escola')->references('id')->on('escolas');
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
        Schema::dropIfExists('professores_info');
    }
}
