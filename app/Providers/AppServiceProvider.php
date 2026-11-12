<?php

namespace App\Providers;

use App\Support\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('master', function ($view) {
            if (Auth::check()) {
                $view->with('menus', Helper::menus());
            }
        });

        View::composer('master', function ($view) {
            if (Auth::check()) {
                $menus = Helper::menus();
                $view->with('menus', $menus)
                     ->with('active', Helper::activeMenu($menus));
            }
        });


    }
}
