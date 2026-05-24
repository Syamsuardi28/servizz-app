<?php
// Lokasi: app/Http/Controllers/TechnicianController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status', '');
        $query  = $filter ? "?status={$filter}" : '';

        $res   = ApiHelper::get("/technicians{$query}");
        $techs = ApiHelper::extractData($res, 'technicians', []);

        if (isset($techs['id_tech'])) {
            $techs = [$techs];
        }

        return view('technicians.index', compact('techs', 'filter'));
    }

    /** GET /technicians/{id} */
    public function show(int $id)
    {
        $res  = ApiHelper::get("/technicians/{$id}");
        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Teknisi tidak ditemukan.', 'error');
            return redirect()->route('technicians.index');
        }
        $tech = ApiHelper::extractData($res, 'technician', []);

        // Fallback if API /technicians/{id} returns empty array but we know it exists
        if (empty($tech)) {
            // Attempt to fetch from the list
            $allRes   = ApiHelper::get("/technicians");
            $allTechs = ApiHelper::extractData($allRes, 'technicians', []);
            if (isset($allTechs['id_tech'])) {
                $allTechs = [$allTechs]; // Single object
            }
            foreach ($allTechs as $t) {
                if (($t['id_tech'] ?? -1) == $id) {
                    $tech = $t;
                    break;
                }
            }
        }

        if (empty($tech)) {
            ApiHelper::flash('Data detail teknisi kosong atau tidak ditemukan.', 'error');
            return redirect()->route('technicians.index');
        }

        // Ambil rating teknisi
        $ratingRes = ApiHelper::get("/rating/technician/{$id}");
        $ratingData = $ratingRes['data'] ?? [];

        // Hitung total order selesai
        $ordersRes = ApiHelper::get("/order");
        $allOrders = ApiHelper::extractData($ordersRes, 'orders', []);
        $totalSelesai = 0;
        
        if (is_array($allOrders) && count($allOrders) > 0) {
            \Illuminate\Support\Facades\Log::info("Order Sample: " . json_encode($allOrders[0]));
        }

        if (is_array($allOrders)) {
            // Jika single object, convert ke array
            if (isset($allOrders['id_order'])) $allOrders = [$allOrders];
            foreach ($allOrders as $o) {
                if (($o['id_mitra'] ?? $o['id_tech'] ?? -1) == $id && ($o['status_order'] ?? '') === 'Selesai') {
                    $totalSelesai++;
                }
            }
        }
        $tech['total_order_selesai'] = $totalSelesai;

        return view('technicians.show', compact('tech', 'ratingData'));
    }

    /** POST /technicians/{id}/verify */
    public function verify(Request $request, int $id)
    {
        $request->validate([
            'status'       => 'required|in:Terverifikasi,Ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $res = ApiHelper::patch("/technicians/{$id}/verify", [
            'status'       => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal memverifikasi.', 'error');
        } else {
            ApiHelper::flash("Mitra berhasil di-{$request->status}.");
        }

        return redirect()->route('technicians.show', $id);
    }
}