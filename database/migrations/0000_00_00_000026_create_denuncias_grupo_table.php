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
                $table->integer('autor_id_denuncia')->unsigned();
                $table->integer('grupo_id')->unsigned();
                $table->integer('autor_id_pub')->unsigned();
                $table->timestamps();


                $table->foreign('grupo_id')
                        ->references('id')
                        ->on('grupo')
                        ->onDelete('cascade');

                $table->foreign('autor_id_denuncia')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');

                //@todo Ver se dá pra fazer isso!
//                $table->foreign('autor_id_pub')
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
