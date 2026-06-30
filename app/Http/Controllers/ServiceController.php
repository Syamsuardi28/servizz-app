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
        try {
            $res = ApiHelper::get('/services');
            $services = ApiHelper::extractData($res, 'services', []);
            if ($res['success'] && empty($services) && is_array($res['data'] ?? null) && count($res['data']) > 0 && !isset($res['data']['services'])) {
                $services = $res['data'];
            }
            $services = is_array($services) ? array_values(array_filter($services, 'is_array')) : [];

            $ordersRes = ApiHelper::get('/order');
            $allOrders = ApiHelper::extractData($ordersRes, 'orders', []);
            if ($ordersRes['success'] && empty($allOrders) && is_array($ordersRes['data'] ?? null) && count($ordersRes['data']) > 0 && !isset($ordersRes['data']['orders'])) {
                $allOrders = $ordersRes['data'];
            }
            $allOrders = is_array($allOrders) ? array_values(array_filter($allOrders, 'is_array')) : [];

            $techRes = ApiHelper::get('/technicians');
            $allTechs = ApiHelper::extractData($techRes, 'technicians', []);
            if ($techRes['success'] && empty($allTechs) && is_array($techRes['data'] ?? null) && count($techRes['data']) > 0 && !isset($techRes['data']['technicians'])) {
                $allTechs = $techRes['data'];
            }
            $allTechs = is_array($allTechs) ? array_values(array_filter($allTechs, 'is_array')) : [];

            return view('services.index', compact('services', 'allOrders', 'allTechs'));

        } catch (\Throwable $e) {
            // Log error lengkap ke stderr agar terlihat di Vercel Logs
            error_log('[ServiceController.index] ERROR: ' . $e->getMessage()
                . ' | File: ' . $e->getFile()
                . ':' . $e->getLine()
                . ' | Trace: ' . substr($e->getTraceAsString(), 0, 500));

            // Return halaman kosong daripada crash
            return view('services.index', [
                'services'  => [],
                'allOrders' => [],
                'allTechs'  => [],
            ]);
        }
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