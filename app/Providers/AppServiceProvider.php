<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.app', function ($view) {
            $notifications = [];
            $unreadCount = 0;

            if (session('servizz_token') && session('servizz_user.role') === 'Admin') {
                $res = \App\Helpers\ApiHelper::get('/notifications?limit=5');
                if ($res['success']) {
                    $notifications = $res['data']['notifications'] ?? [];
                    $unreadCount = count(array_filter($notifications, function($n) {
                        return $n['is_read'] == 0;
                    }));
                }
            }

            $view->with('adminNotifications', $notifications)
                 ->with('adminUnreadCount', $unreadCount);
        });
    }
}
