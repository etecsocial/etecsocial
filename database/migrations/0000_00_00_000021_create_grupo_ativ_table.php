<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoAtivTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_ativ')) {
            Schema::create('grupo_ativ', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('grupo_id')->unsigned();
                $table->integer('rem_id')->unsigned();
                $table->string('desc', 55)->nullable();
                $table->string('tipo', 10);
                $table->date('data_evento');
                $table->timestamps();

                $table->foreign('grupo_id')
                        ->references('id')
                        ->on('grupo')
                        ->onDelete('cascade');
                
                $table->foreign('rem_id')
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
        Schema::dropIfExists('grupo_ativ');
    }

}
