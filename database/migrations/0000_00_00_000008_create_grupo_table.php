<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo')) {
            Schema::create('grupo', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 20);
                $table->string('assunto', 25);
                $table->string('url', 35);
                $table->string('materia', 45)->nullable();
                $table->integer('id_criador')->unsigned();
                $table->string('expiracao', 15)->nullable();
                $table->integer('num_participantes');
                $table->integer('num_discussoes');
                $table->integer('num_perguntas');
                $table->timestamps();

                $table->foreign('id_criador')
                        ->references('id')
                        ->on('users')
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
        Schema::drop('grupo');
    }

}
