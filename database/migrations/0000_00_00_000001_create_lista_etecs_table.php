<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListaEtecsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('lista_etecs')) {
            Schema::create('lista_etecs', function(Blueprint $table) {
                $table->increments('id_etec');
                $table->string('nome', 150);
                $table->integer('cod_prof')->nullable()->unique();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lista_etecs');
    }

}
