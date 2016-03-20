<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDenunciasGrupoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('denuncias_grupo', function(Blueprint $table)
		{
			$table->string('tipo', 20);
			$table->integer('id_pub');
			$table->string('denuncia', 50);
			$table->date('data');
			$table->boolean('visto')->default(0);
			$table->timestamps();
			$table->integer('id_autor_denuncia')->index('fk_denuncias_grupo_users1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_denuncias_grupo_grupo1_idx');
			$table->integer('id_autor_pub')->index('fk_denuncias_grupo_users2_idx');
			$table->primary(['tipo','id_pub','denuncia','id_autor_denuncia','id_grupo']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('denuncias_grupo');
	}

}
