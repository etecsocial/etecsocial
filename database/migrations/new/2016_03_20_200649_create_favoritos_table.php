<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoritosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favoritos', function(Blueprint $table)
		{
			$table->integer('id_user');
			$table->integer('id_post')->unsigned()->index('favoritos_id_post_foreign');
			$table->primary(['id_user','id_post']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('favoritos');
	}

}
