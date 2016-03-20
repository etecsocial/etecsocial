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
			$table->integer('id_user')->index('comentarios_id_user_foreign');
			$table->integer('id_post')->unsigned()->index('comentarios_id_post_foreign');
			$table->string('comentario');
			$table->timestamps();
			$table->integer('relevancia')->nullable();
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
