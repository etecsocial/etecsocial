<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDenunciaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('denuncia')) {
            Schema::create('denuncia', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('id_mensagem');
                $table->date('data');
                $table->string('denuncia', 50);
                $table->string('tipo', 10);
                $table->integer('excluir');
                $table->integer('num_avaliacoes');
                $table->integer('id_prof_1');
                $table->integer('id_prof_2');
                $table->integer('id_prof_3');

                $table->integer('id_usuario')->unsigned();
                $table->integer('id_post')->unsigned();

                $table->foreign('id_post')->references('id')->on('posts');
                $table->foreign('id_usuario')->references('id')->on('users');

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
        Schema::dropIfExists('denuncia');
    }

}
