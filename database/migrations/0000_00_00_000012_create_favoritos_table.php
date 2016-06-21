<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoritosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('favoritos')) {
            Schema::create('favoritos', function(Blueprint $table) {
                $table->integer('id_user')->unsigned();
                $table->integer('id_post')->unsigned();

                //$table->foreign('id_user')->references('id')->on('users');
                //$table->foreign('id_post')->references('id')->on('posts');

                $table->primary(['id_user', 'id_post']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('favoritos');
    }

}
