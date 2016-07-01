<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\Mensagens;

class ViewComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('partials._nav', function($view) {
            $view->with('msgsUnread', Mensagens::countUnread())
                    ->with('infoAcad', User::getInfoAcademica());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
