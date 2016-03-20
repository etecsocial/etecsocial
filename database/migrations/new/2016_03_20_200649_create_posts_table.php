<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_user')->index('posts_id_user_foreign');
			$table->string('titulo')->default('Sem título');
			$table->string('publicacao');
			$table->integer('num_favoritos')->default(0);
			$table->integer('num_reposts')->default(0);
			$table->integer('num_comentarios')->default(0);
			$table->string('url_midia');
			$table->boolean('is_imagem')->default(0);
			$table->boolean('is_video')->default(0);
			$table->boolean('is_publico')->default(0);
			$table->boolean('is_repost')->default(0);
			$table->integer('id_repost')->unsigned();
			$table->boolean('is_question');
			$table->integer('user_repost')->unsigned();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
