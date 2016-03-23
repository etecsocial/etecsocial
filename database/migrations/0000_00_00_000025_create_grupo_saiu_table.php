<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoSaiuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_saiu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('data');
			$table->string('motivo', 50)->nullable();
			
			$table->integer('id_user')->unsigned();
			$table->integer('id_grupo')->unsigned();

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
		Schema::drop('grupo_saiu');
	}

}
