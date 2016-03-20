<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNotificacaosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notificacaos', function(Blueprint $table)
		{
			$table->foreign('id_rem', 'fk_notificacaos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_dest', 'fk_notificacaos_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notificacaos', function(Blueprint $table)
		{
			$table->dropForeign('fk_notificacaos_users1');
			$table->dropForeign('fk_notificacaos_users2');
		});
	}

}
