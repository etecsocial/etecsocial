<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarefasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('tarefas')) {
            Schema::create('tarefas', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('desc', 255);
                $table->integer('data');
                $table->integer('data_checked')->default(0);
                $table->integer('checked')->default(0);
                $table->timestamps();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tarefas');
    }

}
