<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('id_user')->unsigned();
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
                $table->string('titulo', 255)->default('Sem título');
                $table->text('publicacao', 500);
                $table->integer('num_favoritos')->default(0);
                $table->integer('num_reposts')->default(0);
                $table->integer('num_comentarios')->default(0);
                $table->string('url_midia', 255);
                $table->boolean('is_imagem')->default(false);
                $table->boolean('is_video')->default(false);
                $table->boolean('is_publico')->default(false);
                $table->boolean('is_repost')->default(false);
                $table->integer('id_repost')->unsigned();
                $table->boolean('is_question');
                $table->integer('user_repost')->unsigned();
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
        Schema::dropIfExists('posts');
    }

}
