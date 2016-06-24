<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunicadosCoord extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('comunicados_coord')) {
            Schema::create('comunicados_coord', function(Blueprint $table) {
                $table->increments('id')->unique();
                $table->integer('id_coord')->unsigned();
                $table->integer('id_etec')->unsigned();
                $table->text('comunicado', 1000);
                $table->timestamps();

                $table->foreign('id_coord')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');

                $table->foreign('id_etec')
                        ->references('id')
                        ->on('escolas')
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
        Schema::dropIfExists('comunicados_coord');
    }

}
