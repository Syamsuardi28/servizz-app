<?php
// Lokasi: app/Http/Middleware/ServizzAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ServizzAuth
{
    /**
     * Cek apakah user sudah login dan memiliki role yang diizinkan.
     *
     * @param string ...$roles  role yang boleh mengakses (kosong = semua role)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (!Session::has('servizz_token')) {
            return redirect()->route('login')
                ->with('flash_message', 'Silakan login terlebih dahulu.')
                ->with('flash_type', 'warning');
        }

        // Cek role jika diberikan
        if (!empty($roles)) {
            $userRole = Session::get('servizz_user.role', '');
            if (!in_array($userRole, $roles)) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}
