<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePontuacaosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pontuacaos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index('pontuacaos_user_id_foreign');
			$table->integer('pontos');
			$table->string('motivo')->nullable();
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
		Schema::drop('pontuacaos');
	}

}
