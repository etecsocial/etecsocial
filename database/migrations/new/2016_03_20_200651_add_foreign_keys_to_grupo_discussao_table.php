<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGrupoDiscussaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('grupo_discussao', function(Blueprint $table)
		{
			$table->foreign('id_grupo', 'fk_grupo_discussao_grupo1')->references('id')->on('grupo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_autor', 'fk_grupo_discussao_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('grupo_discussao', function(Blueprint $table)
		{
			$table->dropForeign('fk_grupo_discussao_grupo1');
			$table->dropForeign('fk_grupo_discussao_users1');
		});
	}

}
