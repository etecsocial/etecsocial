<?php

use Illuminate\Database\Migrations\Migration;

class CreateColumnTurma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grupo', function ($table) {
            if (!Schema::hasColumn('grupo', 'id_turma')) {
                $table->integer('id_turma')->unsigned()->nullable();
//                $table->foreign('id_turma')->references('id')->on('turmas')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupo', function ($table) {
            if (Schema::hasColumn('grupo', 'id_turma')) {
                $table->dropForeign(['id_turma']);
            }
        });
    }
}
