<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoNotasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_notas', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->string('nota', 200);
			$table->timestamps();
			$table->integer('id_prof')->index('fk_grupo_notas_users1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_notas_grupo1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grupo_notas');
	}

}
