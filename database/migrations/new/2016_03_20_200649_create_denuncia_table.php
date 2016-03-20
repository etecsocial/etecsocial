<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDenunciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('denuncia', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_mensagem');
			$table->date('data');
			$table->string('denuncia', 50);
			$table->string('tipo', 10);
			$table->integer('excluir');
			$table->integer('num_avaliacoes');
			$table->integer('id_prof_1');
			$table->integer('id_prof_2');
			$table->integer('id_prof_3');
			$table->timestamps();
			$table->integer('id_usuario')->index('fk_denuncia_users1_idx');
			$table->integer('id_post')->unsigned()->index('fk_denuncia_posts1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('denuncia');
	}

}
