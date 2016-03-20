<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoAtivTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_ativ', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_ativ_grupo1_idx');
			$table->integer('id_rem')->index('fk_grupo_ativ_users1_idx');
			$table->string('desc', 55)->nullable();
			$table->string('tipo', 10);
			$table->date('data_evento');
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
		Schema::drop('grupo_ativ');
	}

}
