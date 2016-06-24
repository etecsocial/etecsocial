<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('chats')) {
            Schema::create('chats', function(Blueprint $table) {
                $table->increments('id');
                $table->string('msg');
                $table->integer('data');
                $table->boolean('visto')->default(false);
                $table->text('img')->nullable();
                $table->integer('copia_dest')->default(1);
                $table->integer('copia_rem')->default(1);
                $table->integer('destinatario_id')->unsigned();
                $table->integer('rem_idetente')->unsigned();

                $table->foreign('destinatario_id')
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
        Schema::dropIfExists('chats');
    }

}
