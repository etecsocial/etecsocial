<?php

use Illuminate\Database\Migrations\Migration;

class AddColumnModulosTurmas extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('turmas', function ($table) {
            $table->integer('modulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('turmas', function ($table) {
            $table->dropIfExists('modulo');
        });
    }

}
