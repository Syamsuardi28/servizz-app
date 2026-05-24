<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan
     */
    public function index()
    {
        // Ambil data profil terbaru dari API
        $res = ApiHelper::get('/auth/me');
        if (!$res['success']) {
            ApiHelper::flash('Gagal mengambil data profil.', 'error');
            return redirect()->route('dashboard');
        }

        $user = ApiHelper::extractData($res, 'user', []);
        return view('settings.index', compact('user'));
    }

    /**
     * Perbarui data profil (dari halaman pengaturan)
     */
    public function updateProfile(Request $request)
    {
        $rules = [
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'required|string',
        ];

        // Jika user adalah Mitra, izinkan update keahlian
        if (session('servizz_user.role') === 'Mitra') {
            $rules['keahlian'] = 'nullable|string';
        }

        $request->validate($rules);

        $payload = [
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        if (session('servizz_user.role') === 'Mitra') {
            $payload['keahlian'] = $request->keahlian ?? '';
        }

        $res = ApiHelper::patch('/auth/me', $payload);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal memperbarui profil.', 'error');
        } else {
            // Perbarui session nama pengguna jika nama diubah
            session(['servizz_user.nama' => $request->nama]);
            ApiHelper::flash('Profil berhasil diperbarui!');
        }

        return redirect()->route('settings.index');
    }

    /**
     * Unggah foto profil
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $file = $request->file('avatar');
        
        $res = ApiHelper::postMultipart('/auth/avatar', [
            'avatar' => $request->file('avatar')
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengunggah foto profil.', 'error');
        } else {
            // Update session jika perlu
            session(['servizz_user.foto_profil' => $res['data']['foto_profil'] ?? null]);
            ApiHelper::flash('Foto profil berhasil diperbarui!');
        }

        return redirect()->route('settings.index');
    }

    /**
     * Hapus foto profil
     */
    public function deleteAvatar()
    {
        $res = ApiHelper::delete('/auth/avatar');

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal menghapus foto profil.', 'error');
        } else {
            session(['servizz_user.foto_profil' => null]);
            ApiHelper::flash('Foto profil berhasil dihapus!');
        }

        return redirect()->route('settings.index');
    }

    /**
     * Tampilkan halaman ganti kata sandi
     */
    public function password()
    {
        return view('settings.password');
    }

    /**
     * Proses ganti kata sandi
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $res = ApiHelper::patch('/auth/password', [
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengubah kata sandi.', 'error');
            return back();
        }

        ApiHelper::flash('Kata sandi berhasil diubah!');
        return redirect()->route('settings.password');
    }

    /**
     * Tampilkan halaman pengaturan notifikasi
     */
    public function notifications()
    {
        return view('settings.notifications');
    }

    /**
     * Tampilkan halaman status verifikasi
     */
    public function verification()
    {
        $res = ApiHelper::get('/auth/me');
        $user = ApiHelper::extractData($res, 'user', session('servizz_user'));
        return view('settings.verification', compact('user'));
    }

    /**
     * Proses unggah dokumen verifikasi mitra
     */
    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'foto_skck' => 'nullable|file|mimes:jpeg,jpg,png,webp,pdf|max:10240',
            'sertifikat' => 'nullable|file|mimes:jpeg,jpg,png,webp,pdf|max:10240',
        ]);

        $files = [];
        if ($request->hasFile('foto_skck')) {
            $files['foto_skck'] = $request->file('foto_skck');
        }
        if ($request->hasFile('sertifikat')) {
            $files['sertifikat'] = $request->file('sertifikat');
        }

        if (empty($files)) {
            ApiHelper::flash('Tidak ada dokumen yang dipilih.', 'warning');
            return back();
        }

        $res = ApiHelper::postMultipart('/auth/documents', $files);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengunggah dokumen.', 'error');
        } else {
            ApiHelper::flash('Dokumen berhasil diunggah! Status Anda kembali ke Pending untuk ditinjau oleh Admin.');
        }

        return back();
    }
}
