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
			$table->integer('id', true);
			$table->string('username', 20)->nullable()->unique('username_UNIQUE');
			$table->string('email', 45)->unique('email_UNIQUE');
			$table->string('email_alternativo', 45)->nullable()->unique('email_alternativo_UNIQUE');
			$table->integer('tipo');
			$table->string('password', 110);
			$table->string('nome', 110)->nullable();
			$table->text('info_academica', 65535)->nullable();
			$table->string('status', 180)->nullable();
			$table->boolean('online')->default(0);
			$table->integer('reputacao')->default(0);
			$table->integer('num_desafios')->default(0);
			$table->integer('num_auxilios')->default(0);
			$table->string('confirmation_code')->nullable();
			$table->boolean('confirmed')->nullable()->default(0);
			$table->date('nasc');
			$table->string('empresa')->default('0');
			$table->string('cargo')->default('0');
			$table->string('habilidades')->default('0');
			$table->string('cidade')->default('0');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->integer('id_turma')->nullable()->index('fk_users_turmas1_idx');
			$table->integer('id_escola');
			$table->integer('id_modulo');
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
