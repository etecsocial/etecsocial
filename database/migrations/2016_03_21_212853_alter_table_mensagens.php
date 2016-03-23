<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChats extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('chats', function(Blueprint $table) {
            $table->text('doc')->nullable();
            $table->text('video')->nullable();
            $table->text('img')->nullable();
            $table->integer('copia_dest')->default(1);
            $table->integer('copia_rem')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('chats', function(Blueprint $table) {
            $table->dropColumn('doc');
            $table->dropColumn('video');
            $table->dropColumn('img');
            $table->dropColumn('copia_dest');
            $table->dropColumn('compia_rem');
        });
    }

}
