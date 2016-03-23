<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarefasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarefas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_user')->unsigned();
			$table->foreign('id_user')->references('id')->on('users');

			$table->string('desc', 255);
			$table->integer('data');
			$table->integer('data_checked')->default(0);
			$table->integer('checked')->default(0);
						
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
		Schema::drop('tarefas');
	}

}
