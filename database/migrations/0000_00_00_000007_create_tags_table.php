<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function(Blueprint $table) {
                $table->integer('id_post')->unsigned();
                $table->string('tag', 255);
                $table->timestamps();

                $table->foreign('id_post')
                        ->references('id')
                        ->on('posts')
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
        Schema::dropIfExists('tags');
    }

}
