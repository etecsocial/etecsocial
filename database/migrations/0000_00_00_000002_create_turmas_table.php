<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTurmasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('turmas')) {
            Schema::create('turmas', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 150);
                $table->string('sigla', 10);
                $table->integer('modulos');
                $table->integer('escola_id')->unsigned();
                $table->timestamps();

                $table->foreign('escola_id')
                        ->references('id')
                        ->on('escolas')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('turmas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
