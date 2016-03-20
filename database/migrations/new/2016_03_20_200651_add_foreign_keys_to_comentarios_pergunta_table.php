<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToComentariosPerguntaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comentarios_pergunta', function(Blueprint $table)
		{
			$table->foreign('id_grupo', 'fk_comentarios_pergunta_grupo1')->references('id')->on('grupo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_pergunta', 'fk_comentarios_pergunta_grupo_pergunta1')->references('id')->on('grupo_pergunta')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_user', 'fk_comentarios_pergunta_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('comentarios_pergunta', function(Blueprint $table)
		{
			$table->dropForeign('fk_comentarios_pergunta_grupo1');
			$table->dropForeign('fk_comentarios_pergunta_grupo_pergunta1');
			$table->dropForeign('fk_comentarios_pergunta_users1');
		});
	}

}
