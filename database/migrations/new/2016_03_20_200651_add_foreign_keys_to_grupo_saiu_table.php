<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGrupoSaiuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('grupo_saiu', function(Blueprint $table)
		{
			$table->foreign('id_grupo', 'fk_grupo_saiu_grupo1')->references('id')->on('grupo')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_user', 'fk_grupo_saiu_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('grupo_saiu', function(Blueprint $table)
		{
			$table->dropForeign('fk_grupo_saiu_grupo1');
			$table->dropForeign('fk_grupo_saiu_users1');
		});
	}

}
