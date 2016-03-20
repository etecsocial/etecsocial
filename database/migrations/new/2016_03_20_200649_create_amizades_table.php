<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAmizadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('amizades', function(Blueprint $table)
		{
			$table->integer('id_user1')->index('amizades_id_user1_foreign');
			$table->integer('id_user2')->index('amizades_id_user2_foreign');
			$table->boolean('aceitou')->default(0);
			$table->timestamps();
			$table->integer('id', true);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('amizades');
	}

}
