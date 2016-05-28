<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColummMidiaTableMensagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensagens', function ($table) {
            if (!Schema::hasColumn('mensagens', 'midia')) {
                $table->text('midia')->nullable();
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
        Schema::table('mensagens', function ($table) {
            if (Schema::hasColumn('mensagens', 'midia')) {
                $table->dropColumn('midia');
            }
        });
    }
}
