<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoDiscussaoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_discussao')) {
            Schema::create('grupo_discussao', function(Blueprint $table) {
                $table->increments('id');
                $table->string('titulo', 40)->default('Sem título');
                $table->string('assunto', 40);
                $table->string('discussao', 2000);
                $table->integer('autor_id')->unsigned();
                $table->integer('grupo_id')->unsigned();
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
        Schema::dropIfExists('grupo_discussao');
    }

}
