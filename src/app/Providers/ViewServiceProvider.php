<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View::composer('*',function ($view) {
        //     $unreadNotifications = 0;
        //     $notifications = collect();

        //     if (Auth::check()) {
        //         $unreadNotifications = Auth::user()->unreadNotifications->count();
        //         $notifications = Auth::user()->notifications;
        //     }
        //     $view->with(compact('notifications', 'unreadNotifications'));
        // });
    }
}
