<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensagensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('mensagens')) {
            Schema::create('mensagens', function(Blueprint $table) {
                $table->increments('id');
                
                $table->integer('id_remetente')->unsigned();
                $table->foreign('id_remetente')->references('id')->on('users');
                
                $table->integer('id_destinatario')->unsigned();
                $table->foreign('id_destinatario')->references('id')->on('users');
                
                $table->longText('msg');
                $table->string('assunto', 50);
                $table->boolean('visto')->default(0);
                $table->boolean('copia_rem')->default(1);
                $table->boolean('copia_dest')->default(1);
                $table->boolean('arquivado_rem')->default(0);
                $table->boolean('arquivado_dest')->default(0);
                $table->mediumText('doc');
                $table->mediumText('video');
                $table->mediumText('midia');
                
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
        Schema::dropIfExists('mensagens');
    }

}
