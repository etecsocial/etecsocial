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
			$table->string('desc');
			$table->integer('data');
			$table->integer('data_checked')->default(0);
			$table->integer('checked')->default(0);
			$table->timestamps();
			$table->integer('id', true);
			$table->integer('id_user')->index('fk_tarefas_users1_idx');
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
