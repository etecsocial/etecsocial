<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoNotasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_notas')) {

            //Será usada no grupo, mais a frente!

            Schema::create('grupo_notas', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nota', 200);
                $table->integer('id_prof')->unsigned();
                $table->integer('grupo_id')->unsigned();
                $table->timestamps();

                $table->foreign('id_prof')
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
        Schema::dropIfExists('grupo_notas');
    }

}
