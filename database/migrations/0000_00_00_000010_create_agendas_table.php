<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('agendas')) {
            Schema::create('agendas', function(Blueprint $table) {
                $table->increments('id');
                $table->string('title')->nullable();
                $table->text('description', 255)->nullable();
                $table->boolean('is_publico')->nullable()->default(false);
                $table->integer('user_id')->unsigned();
                $table->integer('turma_id')->unsigned()->nullable();

                $table->date('start')->nullable();
                $table->date('end')->nullable();

                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('cascade');
                
                $table->foreign('turma_id')
                        ->references('id')
                        ->on('turmas')
                        ->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('agendas');
    }

}
