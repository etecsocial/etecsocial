<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chats', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_remetente')->unsigned();
			$table->integer('id_destinatario')->unsigned();
			$table->string('msg');
			$table->integer('data');
			$table->boolean('visto')->default(false);

			$table->foreign('id_destinatario')->references('id')->on('users');
			$table->foreign('id_remetente')->references('id')->on('users');
		
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
		Schema::drop('chats');
	}

}
