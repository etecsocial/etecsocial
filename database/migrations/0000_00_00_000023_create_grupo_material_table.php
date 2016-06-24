<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoMaterialTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_material')) {
            Schema::create('grupo_material', function(Blueprint $table) {
                $table->increments('id');
                $table->string('tipo', 15);
                $table->string('nome', 50);
                $table->string('caminho', 100);
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
        Schema::dropIfExists('grupo_material');
    }

}
