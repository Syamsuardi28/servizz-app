<?php
// Lokasi: bootstrap/app.php
// GANTI seluruh isi file ini (khusus Laravel 11).
// Untuk Laravel 10, lihat catatan di bawah.

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        // ── Daftarkan alias middleware SERVIZZ ──
        $middleware->alias([
            'servizz.auth' => \App\Http\Middleware\ServizzAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Log exception to stderr FIRST so it appears at top of Vercel logs
        $exceptions->report(function (\Throwable $e) {
            error_log('=== SERVIZZ EXCEPTION ===');
            error_log('Type: ' . get_class($e));
            error_log('Message: ' . $e->getMessage());
            error_log('File: ' . $e->getFile() . ':' . $e->getLine());
            error_log('Trace: ' . substr($e->getTraceAsString(), 0, 800));
            error_log('=== END EXCEPTION ===');
            return false; // continue to default reporting
        });
    })->create();

/*
|--------------------------------------------------------------------------
| CATATAN UNTUK LARAVEL 10 (jika Anda pakai versi lama)
|--------------------------------------------------------------------------
| Jika Anda menggunakan Laravel 10, JANGAN edit file ini.
| Sebagai gantinya, buka: app/Http/Kernel.php
| Tambahkan baris berikut di dalam $routeMiddleware / $middlewareAliases:
|
|   'servizz.auth' => \App\Http\Middleware\ServizzAuth::class,
|
*/