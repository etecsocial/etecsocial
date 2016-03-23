<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comentarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_user')->unsigned();
			$table->integer('id_post')->unsigned();

			$table->foreign('id_post')->references('id')->on('posts');
			$table->foreign('id_user')->references('id')->on('users');
		
			$table->string('comentario');
			$table->integer('relevancia')->nullable();
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
		Schema::drop('comentarios');
	}

}