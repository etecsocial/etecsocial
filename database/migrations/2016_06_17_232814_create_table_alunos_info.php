<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlunosInfo extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('alunos_info')) {
            Schema::create('alunos_info', function(Blueprint $table) {

                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('profile_photo')->default('default-user.png');
                $table->string('status', 100)->default('Sou novo por aqui, e quero compartilhar conhecimentos com vocês :D');
                $table->string('cidade', 40)->default('Não informado');
                $table->string('email', 40)->default('Não informado');
                $table->string('trabalho', 40)->default('Não informado');
                $table->string('livro', 40)->default('Não informado');
                $table->string('filme', 40)->default('Não informado');
                $table->string('materia', 40)->default('Não informado');

                $table->timestamps();

                $table->foreign('user_id')
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
        Schema::dropIfExists('alunos_info');
    }

}
