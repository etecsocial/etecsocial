<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToComentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comentarios', function(Blueprint $table)
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
		Schema::table('comentarios', function(Blueprint $table)
		{
			$table->dropForeign('comentarios_id_post_foreign');
			$table->dropForeign('comentarios_id_user_foreign');
		});
	}

}
