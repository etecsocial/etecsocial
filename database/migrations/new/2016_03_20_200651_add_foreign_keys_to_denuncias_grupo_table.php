<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDenunciasGrupoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('denuncias_grupo', function(Blueprint $table)
		{
			$table->foreign('id_grupo', 'fk_denuncias_grupo_grupo1')->references('id')->on('grupo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_autor_denuncia', 'fk_denuncias_grupo_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_autor_pub', 'fk_denuncias_grupo_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('denuncias_grupo', function(Blueprint $table)
		{
			$table->dropForeign('fk_denuncias_grupo_grupo1');
			$table->dropForeign('fk_denuncias_grupo_users1');
			$table->dropForeign('fk_denuncias_grupo_users2');
		});
	}

}
