<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_publico')->nullable()->default(0);
			$table->string('title')->nullable();
			$table->text('description', 65535)->nullable();
			$table->date('start')->nullable()->index('idx_start');
			$table->date('end')->nullable()->index('idx_end');
			$table->timestamps();
			$table->integer('id_user')->index('fk_agendas_users1_idx');
			$table->integer('id_turma')->default(0)->index('fk_agendas_turmas1_idx');
			$table->integer('id_modulo');
			$table->primary(['id','id_turma']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendas');
	}

}
