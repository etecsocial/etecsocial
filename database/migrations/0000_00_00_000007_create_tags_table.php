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
                //$table->foreign('id_post')->references('id')->on('posts')->onUpdate('RESTRICT')->onDelete('CASCADE');
                $table->string('tag', 255);
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
        Schema::dropIfExists('tags');
    }

}
