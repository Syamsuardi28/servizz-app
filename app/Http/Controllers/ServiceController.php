<?php
// Lokasi: app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** GET /services-list */
    public function index()
    {
        $res      = ApiHelper::get('/services');
        $services = ApiHelper::extractData($res, 'services', []);

        $ordersRes = ApiHelper::get('/order');
        $allOrders = ApiHelper::extractData($ordersRes, 'orders', []);
        if (empty($allOrders) && count($ordersRes['data'] ?? []) > 0 && !isset($ordersRes['data']['orders'])) {
            $allOrders = $ordersRes['data'];
        }

        $techRes = ApiHelper::get('/technicians');
        $allTechs = ApiHelper::extractData($techRes, 'technicians', []);
        if (empty($allTechs) && count($techRes['data'] ?? []) > 0 && !isset($techRes['data']['technicians'])) {
            $allTechs = $techRes['data'];
        }

        return view('services.index', compact('services', 'allOrders', 'allTechs'));
    }

    /** POST /services-list */
    public function store(Request $request)
    {
        $request->validate([
            'nama_service' => 'required|string|max:100',
            'deskripsi'    => 'nullable|string|max:500',
            'status'       => 'nullable|in:0,1',
        ]);

        $res = ApiHelper::post('/services', [
            'nama_service' => $request->nama_service,
            'deskripsi'    => $request->deskripsi,
            'is_active'    => $request->has('status') ? (int) $request->status : 1,
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal menambah kategori.', 'error');
        } else {
            ApiHelper::flash('Kategori jasa "' . $request->nama_service . '" berhasil ditambahkan.');
        }

        return redirect()->route('services.index');
    }
}