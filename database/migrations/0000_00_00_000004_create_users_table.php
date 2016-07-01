<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('username', 255)->unique();
                $table->string('email', 255)->unique();
                $table->string('email_instuticional', 255)->unique()->nullable();
                $table->string('password', 110);
                $table->smallInteger('type')->default(1); // (1 = normal / 2 = professor / 3 = moderador)
                $table->string('status', 255)->nullable()->default('Curti o ETEC Social!');
                $table->boolean('online')->default(false);
                $table->date('birthday')->nullable();
                $table->smallInteger('first_login')->default(0); // utilizado para o provider login e RM login (1 = provider login / 2 = RM Login)

                $table->smallInteger('provider_id')->nullable(); // 1 = facebook, 2 = google
                $table->bigInteger('provider_user_id')->unique()->nullable();

                $table->string('confirmation_code')->nullable();
                $table->boolean('confirmed')->nullable()->default(false);
                
                $table->rememberToken();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
