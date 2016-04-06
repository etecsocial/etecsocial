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
                $table->integer('id_destinatario')->unsigned();
                $table->integer('id_remetente')->unsigned();
                $table->foreign('id_destinatario')->references('id')->on('users');
                $table->foreign('id_remetente')->references('id')->on('users');

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
