<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrupoUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('grupo_user')) {
            Schema::create('grupo_user', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('grupo_id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->boolean('is_admin')->default(false);
                $table->boolean('is_banido')->default(false);
                $table->timestamps();

                $table->foreign('grupo_id')
                        ->references('id')
                        ->on('grupo')
                        ->onDelete('cascade');

                $table->foreign('user_id')
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
        Schema::dropIfExists('grupo_user');
    }

}
