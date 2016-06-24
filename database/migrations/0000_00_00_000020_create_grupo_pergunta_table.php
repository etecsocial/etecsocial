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
                $table->integer('grupo_id')->unsigned();
                $table->integer('autor_id')->unsigned();
                $table->timestamps();

                $table->foreign('autor_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('grupo_id')
                        ->references('id')
                        ->on('grupo')
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
        Schema::dropIfExists('grupo_pergunta');
    }

}
