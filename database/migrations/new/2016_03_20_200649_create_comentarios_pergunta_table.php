<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosPerguntaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comentarios_pergunta', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('comentario', 300);
			$table->integer('id_user')->index('fk_comentarios_pergunta_users1_idx');
			$table->integer('id_pergunta')->index('fk_comentarios_pergunta_grupo_pergunta1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_comentarios_pergunta_grupo1_idx');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comentarios_pergunta');
	}

}
