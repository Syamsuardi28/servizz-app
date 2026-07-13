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

        // Auto-run migrations on SQLite if tables don't exist (critical for Vercel ephemeral /tmp database)
        try {
            if (config('database.default') === 'sqlite') {
                $dbPath = config('database.connections.sqlite.database');
                if ($dbPath && $dbPath !== ':memory:' && !file_exists($dbPath)) {
                    $dir = dirname($dbPath);
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    touch($dbPath);
                }
                
                if (!\Illuminate\Support\Facades\Schema::hasTable('order_progress')) {
                    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                }
            }
        } catch (\Throwable $e) {
            error_log('[AppServiceProvider AutoMigration] Failed: ' . $e->getMessage());
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
