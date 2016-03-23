<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificacaosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificacaos', function(Blueprint $table)
		{
			$table->integer('id', false, true);
			$table->integer('id_rem')->unsigned();
			$table->integer('id_dest')->unsigned();
			$table->primary(['id', 'id_dest']);

			$table->string('texto', 60);
			$table->boolean('is_post')->default(0);
			$table->boolean('visto');
			$table->string('action', 90)->default('0');
			$table->integer('data');
			
			$table->foreign('id_rem')->references('id')->on('users');
			$table->foreign('id_dest')->references('id')->on('users');
			
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
		Schema::drop('notificacaos');
	}

}
