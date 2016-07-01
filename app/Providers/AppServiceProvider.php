<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserRegister;
use App\User;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        User::created(function ($user) {
            event(new UserRegister($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
