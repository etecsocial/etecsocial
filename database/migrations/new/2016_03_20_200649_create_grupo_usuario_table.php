<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_usuario', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_usuario_grupo1_idx');
			$table->integer('id_user')->index('fk_grupo_usuario_users1_idx');
			$table->boolean('is_admin')->default(0);
			$table->boolean('is_banido')->default(0);
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
		Schema::drop('grupo_usuario');
	}

}
