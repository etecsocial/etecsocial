<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComunicadosCoord extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() { // esta migração estava com erro, não exclui porque ia dar mais erro ainda.
         Schema::dropIfExists('comunicados_coord');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('comunicados_coord');
    }

}
