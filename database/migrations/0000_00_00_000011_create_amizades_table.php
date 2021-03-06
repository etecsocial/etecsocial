<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAmizadesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('amizades')) {
            Schema::create('amizades', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id1')->unsigned();
                $table->integer('user_id2')->unsigned();
                $table->boolean('aceitou')->default(false);
                $table->timestamps();

                $table->foreign('user_id1')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('user_id2')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('amizades');
    }

}
