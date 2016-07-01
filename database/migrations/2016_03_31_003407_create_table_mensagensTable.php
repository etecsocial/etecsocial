<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMensagensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('mensagens')) {
            Schema::create('mensagens', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('remetente_id')->unsigned();
                $table->integer('destinatario_id')->unsigned();

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

                $table->foreign('remetente_id')
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
        Schema::dropIfExists('mensagens');
    }

}
