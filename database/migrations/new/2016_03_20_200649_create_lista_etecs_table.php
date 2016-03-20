<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListaEtecsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lista_etecs', function(Blueprint $table)
		{
			$table->integer('id_etec', true);
			$table->string('nome', 90)->nullable();
			$table->integer('cod_prof')->nullable()->unique('cod_prof_UNIQUE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lista_etecs');
	}

}
