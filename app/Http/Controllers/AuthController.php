<?php
// Lokasi: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /** GET /login */
    public function showLogin()
    {
        if (session('servizz_token')) {
            $role = session('servizz_user.role');
            return $role === 'Admin' ? redirect()->route('dashboard') : redirect()->route('orders.index');
        }
        return view('auth.login');
    }

    /** POST /login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $res = ApiHelper::post('/auth/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if (!$res['success']) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $res['data']['message'] ?? 'Login gagal.');
        }

        $data = $res['data'];

        // Simpan ke session
        session([
            'servizz_token'     => $data['token'],
            'servizz_user'      => array_merge($data['user'], ['role' => $data['user_role']]),
        ]);

        ApiHelper::flash('Selamat datang, ' . ($data['user']['nama'] ?? '') . '!');

        $role = $data['user_role'] ?? 'Pelanggan';
        if ($role === 'Admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('orders.index');
    }

    /** GET /register */
    public function showRegister()
    {
        if (session('servizz_token')) {
            $role = session('servizz_user.role');
            return $role === 'Admin' ? redirect()->route('dashboard') : redirect()->route('orders.index');
        }
        return view('auth.register');
    }

    /** POST /register */
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|max:150',
            'password' => 'required|string|min:6',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string|max:500',
            'role'     => 'required|in:Pelanggan,Mitra',
            'file_skck' => 'required_if:role,Mitra|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sertifikat' => 'required_if:role,Mitra|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $skckUrl = null;
        $sertifikatUrl = null;

        if ($request->role === 'Mitra') {
            try {
                $targetDir = public_path('uploads');
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }

                // Check if directory is writeable (fails on serverless hosting like Vercel)
                $isWritable = is_writable($targetDir) || is_writable(public_path());

                if ($request->hasFile('file_skck')) {
                    $file = $request->file('file_skck');
                    $filename = time() . '_skck_' . $file->getClientOriginalName();
                    if ($isWritable) {
                        $file->move($targetDir, $filename);
                        $skckUrl = asset('uploads/' . $filename);
                    } else {
                        // Fallback to placeholder on read-only hosting
                        $skckUrl = 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400';
                    }
                }

                if ($request->hasFile('file_sertifikat')) {
                    $file = $request->file('file_sertifikat');
                    $filename = time() . '_sertifikat_' . $file->getClientOriginalName();
                    if ($isWritable) {
                        $file->move($targetDir, $filename);
                        $sertifikatUrl = asset('uploads/' . $filename);
                    } else {
                        // Fallback to placeholder on read-only hosting
                        $sertifikatUrl = 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400';
                    }
                }
            } catch (\Throwable $e) {
                // Safe fallback in case of write permission error on Vercel
                $skckUrl = 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400';
                $sertifikatUrl = 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400';
                error_log('[AuthController Register Upload] Failed: ' . $e->getMessage());
            }
        }

        $res = ApiHelper::post('/auth/register', [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'role'     => $request->role,
            'file_skck' => $skckUrl,
            'file_sertifikat' => $sertifikatUrl,
        ]);

        if (!$res['success']) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', $res['data']['message'] ?? 'Registrasi gagal.');
        }

        ApiHelper::flash('Registrasi berhasil! Silakan login menggunakan akun baru Anda.');

        return redirect()->route('login');
    }

    /** POST /logout */
    public function logout()
    {
        // Logout dari session
        session()->forget(['servizz_token', 'servizz_user']);
        return redirect()->route('login')
            ->with('flash_message', 'Anda telah logout.')
            ->with('flash_type', 'info');
    }
}