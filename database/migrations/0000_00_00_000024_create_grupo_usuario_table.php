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
			$table->increments('id');
			$table->integer('id_grupo')->unsigned();
			$table->integer('id_user')->unsigned();
			$table->boolean('is_admin')->default(false);
			$table->boolean('is_banido')->default(false);

			$table->foreign('id_grupo')->references('id')->on('grupo');
			$table->foreign('id_user')->references('id')->on('users');

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
