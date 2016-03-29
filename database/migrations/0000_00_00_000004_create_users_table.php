<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 255);
			$table->string('username', 20)->nullable()->unique();
			$table->string('email', 255)->unique();
			$table->string('password', 110);
			$table->smallInteger('tipo')->default(1); // (1 = normal / 2 = professor / 3 = moderador)
			$table->string('status', 255)->nullable();
			$table->boolean('online')->default(false);
			$table->integer('reputacao')->default(0);
			$table->date('nasc')->nullable();
			$table->string('cidade')->nullable();

			$table->text('info_academica')->nullable();

			$table->bigInteger('provider_user_id')->unique()->nullable();

			$table->string('confirmation_code')->nullable();
			$table->boolean('confirmed')->nullable()->default(false);

			$table->integer('id_turma')->unsigned()->default(1);
			$table->foreign('id_turma')->references('id')->on('turmas');
			
			$table->integer('id_escola')->unsigned()->default(1); // acho que não é necessário, pois já está linkado com id_turma a escola
			$table->foreign('id_escola')->references('id_etec')->on('lista_etecs');

			$table->integer('id_modulo')->unsigned()->default(1);
			$table->foreign('id_modulo')->references('id')->on('modulos');

			$table->string('remember_token')->nullable();
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
		Schema::drop('users');
	}

}
