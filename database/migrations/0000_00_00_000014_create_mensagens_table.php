<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMensagensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mensagens', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_remetente')->unsigned();
            $table->integer('id_destinatario')->unsigned();
            $table->string('msg');
            $table->integer('data');
            $table->boolean('visto')->default(false);
            $table->text('doc')->nullable();
            $table->text('video')->nullable();
            $table->text('img')->nullable();
            $table->integer('copia_dest')->default(1);
            $table->integer('copia_rem')->default(1);
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
    public function down() {
        Schema::drop('mensagens');
    }

}
