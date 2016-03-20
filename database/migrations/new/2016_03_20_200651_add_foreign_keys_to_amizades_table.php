<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAmizadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('amizades', function(Blueprint $table)
		{
			$table->foreign('id_user1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_user2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('amizades', function(Blueprint $table)
		{
			$table->dropForeign('amizades_id_user1_foreign');
			$table->dropForeign('amizades_id_user2_foreign');
		});
	}

}
