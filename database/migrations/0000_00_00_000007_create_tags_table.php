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
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
            Schema::create('post_tag', function(Blueprint $table) {
                $table->integer('post_id')->unsigned()->index();
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->integer('tag_id')->unsigned()->index();
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
    }

}
