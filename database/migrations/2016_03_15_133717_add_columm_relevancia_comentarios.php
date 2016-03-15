<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColummRelevanciaComentarios extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('comentarios', function(Blueprint $table) {
            $table->integer('relevancia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('comentarios', function ($table) {
            $table->dropColumn('relevancia');
        });
    }

}
