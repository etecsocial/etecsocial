<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToComentariosDiscussaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comentarios_discussao', function(Blueprint $table)
		{
			$table->foreign('id_grupo', 'fk_comentarios_discussao_grupo1')->references('id')->on('grupo')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_discussao', 'fk_comentarios_discussao_grupo_discussao1')->references('id')->on('grupo_discussao')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_user', 'fk_comentarios_discussao_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('comentarios_discussao', function(Blueprint $table)
		{
			$table->dropForeign('fk_comentarios_discussao_grupo1');
			$table->dropForeign('fk_comentarios_discussao_grupo_discussao1');
			$table->dropForeign('fk_comentarios_discussao_users1');
		});
	}

}
