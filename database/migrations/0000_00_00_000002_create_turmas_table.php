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
                $table->integer('id_escola')->unsigned();
                $table->timestamps();

                $table->foreign('id_escola')
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
        Schema::dropIfExists('turmas');
    }

}
