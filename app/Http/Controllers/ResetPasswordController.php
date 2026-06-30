<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\ApiHelper;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Generate token & save to local SQLite
        $token = Str::random(60);
        
        // Buat tabel jika belum ada (secara dinamis untuk jaga-jaga)
        try {
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now()
                ]
            );
        } catch (\Exception $e) {
            // Abaikan jika tabel belum ada, anggap sukses (mockup)
        }

        // Mock pengiriman email dengan menulis log atau Flash message
        // Dalam implementasi nyata, kita gunakan Mail::to()->send()
        
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        ApiHelper::flash('Tautan pemulihan kata sandi telah dikirim ke email Anda. (MOCK: ' . $resetUrl . ')', 'success');

        return back();
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Mock update password to external API
        $res = ApiHelper::patch('/auth/reset-password', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Hapus token lokal
        try {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        } catch (\Exception $e) {}

        ApiHelper::flash('Kata sandi berhasil diubah! Silakan login dengan kata sandi baru.', 'success');

        return redirect()->route('login');
    }
}
