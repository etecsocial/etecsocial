<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTurmasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('turmas', function(Blueprint $table)
		{
			$table->foreign('id_escola', 'fk_turmas_lista_etecs1')->references('id_etec')->on('lista_etecs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('turmas', function(Blueprint $table)
		{
			$table->dropForeign('fk_turmas_lista_etecs1');
		});
	}

}
