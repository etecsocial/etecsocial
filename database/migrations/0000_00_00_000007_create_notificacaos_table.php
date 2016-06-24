<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificacaosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('notificacaos')) {
            Schema::create('notificacaos', function(Blueprint $table) {
                $table->integer('id', false, true);
                $table->integer('rem_id')->unsigned();
                $table->integer('id_dest')->unsigned();

                $table->string('texto', 60);
                $table->boolean('is_post')->default(0);
                $table->boolean('visto');
                $table->string('action', 90)->default('0');
                $table->integer('data');

                $table->foreign('rem_id')
                        ->references('id')
                        ->on('users')
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
        Schema::dropIfExists('notificacaos');
    }

}
