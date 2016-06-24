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
                $table->integer('post_id')->unsigned();
                $table->string('tag', 255);
                $table->timestamps();

                $table->foreign('post_id')
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
