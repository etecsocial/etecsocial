<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 20);
			$table->string('assunto', 25);
			$table->string('url', 35);
			$table->date('criacao');
			$table->string('materia', 45)->nullable();
			$table->integer('id_criador');
			$table->string('expiracao', 15)->nullable();
			$table->integer('num_participantes');
			$table->integer('num_discussoes');
			$table->integer('num_perguntas');
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
		Schema::drop('grupo');
	}

}
