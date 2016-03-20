<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoPerguntaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupo_pergunta', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('assunto', 30)->default('Sem assunto');
			$table->string('pergunta', 200);
			$table->date('data');
			$table->timestamps();
			$table->integer('id_grupo')->unsigned()->index('fk_grupo_pergunta_grupo1_idx');
			$table->integer('id_autor')->index('fk_grupo_pergunta_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grupo_pergunta');
	}

}
