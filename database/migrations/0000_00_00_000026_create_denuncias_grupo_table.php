<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDenunciasGrupoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('denuncias_grupo')) {
            Schema::create('denuncias_grupo', function(Blueprint $table) {
                $table->string('tipo', 20);
                $table->integer('id_pub');
                $table->string('denuncia', 50);
                $table->date('data');

                $table->boolean('visto')->default(false);
                $table->integer('id_autor_denuncia')->unsigned();
                $table->integer('id_grupo')->unsigned();
                $table->integer('id_autor_pub')->unsigned();
                $table->timestamps();


                $table->foreign('id_grupo')
                        ->references('id')
                        ->on('grupo')
                        ->onDelete('cascade');

                $table->foreign('id_autor_denuncia')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');

                //@todo Ver se dá pra fazer isso!
//                $table->foreign('id_autor_pub')
//                        ->references('id')
//                        ->on('users')
//                        ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('denuncias_grupo');
    }

}
