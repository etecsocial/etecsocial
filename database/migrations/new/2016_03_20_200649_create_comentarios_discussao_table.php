<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosDiscussaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comentarios_discussao', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('comentario', 1000);
			$table->timestamps();
			$table->integer('id_discussao')->index('fk_comentarios_discussao_grupo_discussao1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_comentarios_discussao_grupo1_idx');
			$table->integer('id_user')->index('fk_comentarios_discussao_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comentarios_discussao');
	}

}
