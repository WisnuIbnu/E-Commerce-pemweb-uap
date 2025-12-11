<?php

namespace App\Providers;

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
        view()->composer('layouts.navigation', function ($view) {
            $hasTransaction = false;

            if (auth()->check() && auth()->user()->buyer) {
                $hasTransaction = auth()->user()->buyer
                    ->transactions()
                    ->exists();
            }

            $view->with('hasTransaction', $hasTransaction);
        });
    }
}
