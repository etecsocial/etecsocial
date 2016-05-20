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
                $table->integer('id', false, true);
                $table->string('title')->nullable();
                $table->text('description', 65535)->nullable();
                $table->boolean('is_publico')->nullable()->default(false);
                $table->integer('id_user')->unsigned();
                $table->integer('id_turma')->unsigned()->default(0);
                $table->primary(['id', 'id_turma']);

                $table->date('start')->nullable();
                $table->date('end')->nullable();

                $table->foreign('id_user')->references('id')->on('users');
                $table->foreign('id_turma')->references('id')->on('turmas');

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
