<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnProfessoresTurmaModulo extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('professores_turma', function ($table) {
            $table->dropColumn('modulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('professores_turma', function ($table) {
            $table->integer('modulo');
        });
    }

}
