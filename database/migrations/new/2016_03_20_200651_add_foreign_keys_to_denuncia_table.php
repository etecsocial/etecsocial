<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDenunciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('denuncia', function(Blueprint $table)
		{
			$table->foreign('id_post', 'fk_denuncia_posts1')->references('id')->on('posts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuario', 'fk_denuncia_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('denuncia', function(Blueprint $table)
		{
			$table->dropForeign('fk_denuncia_posts1');
			$table->dropForeign('fk_denuncia_users1');
		});
	}

}
