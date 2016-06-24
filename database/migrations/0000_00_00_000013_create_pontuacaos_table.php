<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePontuacaosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('pontuacaos')) {
            Schema::create('pontuacaos', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('id_user')->unsigned();
                $table->integer('pontos');
                $table->string('motivo')->nullable();
                $table->timestamps();

                $table->foreign('id_user')
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
        Schema::dropIfExists('pontuacaos');
    }

}
