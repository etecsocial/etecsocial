<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEscolasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('escolas')) {
            Schema::create('escolas', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 150);
                $table->integer('cod_prof')->nullable()->unique();
                $table->integer('cod_coord')->nullable()->unique();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('escolas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
