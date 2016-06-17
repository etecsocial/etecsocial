<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesafioTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('escolas', function ($table) {
            if (!Schema::hasColumn('escolas', 'cod_coord')) {
                $table->integer('cod_coord')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escolas', function ($table) {
            if (Schema::hasColumn('escolas', 'cod_coord')) {
                $table->dropColumn('cod_coord');
            }
        });
    }
}
