<?php
// Lokasi: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** GET /users */
    public function index(Request $request)
    {
        $role  = $request->query('role', '');
        $query = $role ? "?role={$role}" : '';

        $res   = ApiHelper::get("/admin/users{$query}");
        $users = ApiHelper::extractData($res, 'users', []);

        return view('users.index', compact('users', 'role'));
    }

    /** GET /users/{id} */
    public function show(int $id)
    {
        $res   = ApiHelper::get("/admin/users");
        $users = ApiHelper::extractData($res, 'users', []);
        
        $user = null;
        foreach ($users as $u) {
            if ($u['id_user'] == $id) {
                $user = $u;
                break;
            }
        }

        if (!$user) {
            ApiHelper::flash('Pengguna tidak ditemukan.', 'error');
            return redirect()->route('users.index');
        }

        // Ambil riwayat pesanan (karena Admin, mengambil semua order, lalu filter)
        $ordersRes = ApiHelper::get("/order");
        $allOrders = ApiHelper::extractData($ordersRes, 'orders', []);
        
        $orders = [];
        if (is_array($allOrders)) {
            foreach ($allOrders as $o) {
                // Admin orders punya id_order, tgl, dll. sayangnya struktur Admin tak memuat id_user secara default
                // Tapi ini cuma perkiraan, kita akan tampilkan kosongan jika tdk ketemu
                if (($o['nama_pelanggan'] ?? '') === $user['nama'] || ($o['nama_mitra'] ?? '') === $user['nama']) {
                    $orders[] = $o;
                }
            }
        }

        return view('users.show', compact('user', 'orders'));
    }

    /** POST /users/{id}/toggle */
    public function toggle(int $id)
    {
        $res = ApiHelper::patch("/admin/users/{$id}/toggle-active");

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengubah status.', 'error');
        } else {
            ApiHelper::flash($res['data']['message'] ?? 'Status akun berhasil diubah.');
        }

        return redirect()->route('users.index');
    }
}