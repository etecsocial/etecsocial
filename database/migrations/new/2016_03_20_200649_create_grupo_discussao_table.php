<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoDiscussaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_discussao', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('titulo', 40)->default('Sem título');
			$table->string('assunto', 40);
			$table->string('discussao', 2000);
			$table->integer('id_autor')->index('fk_grupo_discussao_users1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_discussao_grupo1_idx');
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
		Schema::drop('grupo_discussao');
	}

}
