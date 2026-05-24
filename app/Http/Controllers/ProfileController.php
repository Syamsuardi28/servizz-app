<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
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

        // Kalkulasi Statistik Pesanan
        $stats = [
            'total'   => 0,
            'selesai' => 0,
            'proses'  => 0,
        ];

        $orders = [];
        if (in_array(session('servizz_user.role'), ['Pelanggan', 'Mitra'])) {
            $ordersRes = ApiHelper::get('/order');
            $orders = ApiHelper::extractData($ordersRes, 'orders', []);
            
            $stats['total'] = count($orders);
            $stats['selesai'] = count(array_filter($orders, fn($o) => $o['status_order'] === 'Selesai'));
            $stats['proses'] = count(array_filter($orders, fn($o) => !in_array($o['status_order'], ['Selesai', 'Dibatalkan', 'Menunggu'])));
        }

        return view('profile.index', compact('user', 'stats', 'orders'));
    }
}
