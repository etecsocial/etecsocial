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
			$table->integer('id', true);
			$table->integer('id_rem')->index('fk_notificacaos_users1_idx');
			$table->integer('id_dest')->index('fk_notificacaos_users2_idx');
			$table->string('texto', 60);
			$table->boolean('is_post')->default(0);
			$table->boolean('visto');
			$table->string('action', 90)->default('0');
			$table->integer('data');
			$table->timestamps();
			$table->primary(['id','id_dest']);
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
