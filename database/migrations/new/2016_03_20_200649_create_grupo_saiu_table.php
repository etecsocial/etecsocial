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
			$table->integer('id', true);
			$table->date('data');
			$table->string('motivo', 50)->nullable();
			$table->timestamps();
			$table->integer('id_user')->index('fk_grupo_saiu_users1_idx');
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_saiu_grupo1_idx');
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
