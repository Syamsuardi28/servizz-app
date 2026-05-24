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
        // ── Daftarkan alias middleware SERVIZZ ──
        $middleware->alias([
            'servizz.auth' => \App\Http\Middleware\ServizzAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
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