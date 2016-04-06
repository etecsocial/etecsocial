<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoAtivTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_ativ')) {
            Schema::create('grupo_ativ', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('id_grupo')->unsigned();
                $table->integer('id_rem')->unsigned();
                $table->string('desc', 55)->nullable();
                $table->string('tipo', 10);
                $table->date('data_evento');

                $table->foreign('id_grupo')->references('id')->on('grupo');
                $table->foreign('id_rem')->references('id')->on('users');

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
        Schema::dropIfExists('grupo_ativ');
    }

}
