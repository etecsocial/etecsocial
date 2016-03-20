<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFavoritosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('favoritos', function(Blueprint $table)
		{
			$table->foreign('id_post')->references('id')->on('posts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('favoritos', function(Blueprint $table)
		{
			$table->dropForeign('favoritos_id_post_foreign');
			$table->dropForeign('favoritos_id_user_foreign');
		});
	}

}
