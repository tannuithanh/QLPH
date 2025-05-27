<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $userSession = Auth::user();

            if ($userSession) {
                // Luôn eager load roles để có sẵn danh sách
                $userSession->load('roles');
            }
            // dd($user->id);
            $view->with('user', $userSession);
        });
    }
}
