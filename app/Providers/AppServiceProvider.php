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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('layouts.app', function ($view) {
            $notifications = [];
            $unreadCount = 0;

            try {
                if (session('servizz_token') && session('servizz_user.role') === 'Admin') {
                    $res = \App\Helpers\ApiHelper::get('/notifications?limit=5');
                    if ($res['success']) {
                        $rawNotifs = $res['data']['notifications'] ?? [];
                        $notifications = is_array($rawNotifs) ? array_filter($rawNotifs, 'is_array') : [];
                        $unreadCount = count(array_filter($notifications, function($n) {
                            return is_array($n) && ($n['is_read'] ?? 1) == 0;
                        }));
                    }
                }
            } catch (\Throwable $e) {
                error_log('[AppServiceProvider ViewComposer] ' . $e->getMessage());
            }

            $view->with('adminNotifications', $notifications)
                 ->with('adminUnreadCount', $unreadCount);
        });
    }
}
