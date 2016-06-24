<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesafiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('desafios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('subject');
            $table->date('finish');
            $table->integer('reward_points')->default(10);
            $table->integer('responsible_id')->unsigned();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('responsible_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('desafios');
    }

}
