<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoMaterialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_material', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('tipo', 15);
			$table->string('nome', 50);
			$table->string('caminho', 100);
			$table->integer('id_autor')->index('fk_grupo_material_users1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_material_grupo1_idx');
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
		Schema::drop('grupo_material');
	}

}
