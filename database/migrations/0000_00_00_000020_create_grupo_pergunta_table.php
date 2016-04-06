<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoPerguntaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_pergunta')) {
            Schema::create('grupo_pergunta', function(Blueprint $table) {
                $table->increments('id');
                $table->string('assunto', 30)->default('Sem assunto');
                $table->string('pergunta', 200);
                $table->date('data');
                $table->integer('id_grupo')->unsigned();
                $table->integer('id_autor')->unsigned();

                $table->foreign('id_grupo')->references('id')->on('grupo');
                $table->foreign('id_autor')->references('id')->on('users');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('grupo_pergunta');
    }

}
