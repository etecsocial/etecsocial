<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfessoresInfo extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('professores_info')) {
            Schema::create('professores_info', function(Blueprint $table) {

                $table->uid('user_id');
                //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->integer('id_escola');
                
                $table->string('profile_photo')->default('default-user.png');
                $table->string('status', 100)->default('Sou novo por aqui, e quero compartilhar conhecimentos com vocês :D');
                $table->string('cidade', 40)->default('Não informado');
                $table->string('formacao', 40)->default('Não informado');
                $table->string('email', 40)->default('Não informado');
                $table->string('livro', 40)->default('Não informado');
                $table->string('filme', 40)->default('Não informado');
                $table->string('materia', 40)->default('Não informado');

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
        Schema::dropIfExists('professores_info');
    }

}
