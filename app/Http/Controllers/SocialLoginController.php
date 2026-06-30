<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            ApiHelper::flash('Login dengan ' . ucfirst($provider) . ' dibatalkan.', 'error');
            return redirect()->route('login');
        }

        $email = $socialUser->getEmail();
        $name = $socialUser->getName();
        $providerId = $socialUser->getId();

        // 1. Simpan ke database lokal untuk pencatatan (SQLite)
        try {
            DB::table('social_logins')->updateOrInsert(
                ['email' => $email],
                [
                    'provider' => $provider,
                    'provider_id' => $providerId,
                    'name' => $name,
                    'created_at' => Carbon::now()
                ]
            );
        } catch (\Exception $e) {
            // Abaikan jika tabel belum ada
        }

        // 2. Coba Login via External API
        // Karena kita tidak tahu password asli mereka di API, kita gunakan "social_password_XYZ"
        $socialPassword = 'social_' . substr(md5($email), 0, 10);
        
        $res = ApiHelper::post('/auth/login', [
            'email' => $email,
            'password' => $socialPassword
        ]);

        if (!$res['success']) {
            // Jika gagal login (mungkin akun belum ada di external API), kita daftarkan otomatis!
            $resReg = ApiHelper::post('/auth/register', [
                'nama' => $name,
                'email' => $email,
                'password' => $socialPassword,
                'no_hp' => '-',
                'alamat' => '-',
                'role' => 'Pelanggan'
            ]);

            if ($resReg['success']) {
                // Login lagi setelah register
                $res = ApiHelper::post('/auth/login', [
                    'email' => $email,
                    'password' => $socialPassword
                ]);
            } else {
                ApiHelper::flash('Gagal mendaftar akun dari Google: ' . ($resReg['data']['message'] ?? ''), 'error');
                return redirect()->route('login');
            }
        }

        if ($res['success']) {
            $data = $res['data'];
            session([
                'servizz_token' => $data['token'],
                'servizz_user'  => array_merge($data['user'], ['role' => $data['user_role']]),
            ]);

            ApiHelper::flash('Berhasil masuk dengan ' . ucfirst($provider) . '!');
            return redirect()->route('orders.index');
        }

        ApiHelper::flash('Gagal masuk. Silakan coba lagi.', 'error');
        return redirect()->route('login');
    }
}
