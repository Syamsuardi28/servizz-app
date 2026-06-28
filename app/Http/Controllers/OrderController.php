<?php
// Lokasi: app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /** GET /orders */
    public function index(Request $request)
    {
        $res    = ApiHelper::get('/order');
        $orders = ApiHelper::extractData($res, 'orders', []);

        // Filter status
        $filterStatus = $request->query('status', '');
        if ($filterStatus) {
            $orders = array_filter($orders, fn($o) => $o['status_order'] === $filterStatus);
        }

        // Sorting
        $sort = $request->query('sort', 'date_desc');
        if ($sort === 'date_desc') {
            usort($orders, fn($a, $b) => strtotime($b['tgl_kunjungan'] ?? 0) - strtotime($a['tgl_kunjungan'] ?? 0));
        } elseif ($sort === 'date_asc') {
            usort($orders, fn($a, $b) => strtotime($a['tgl_kunjungan'] ?? 0) - strtotime($b['tgl_kunjungan'] ?? 0));
        } elseif ($sort === 'price_desc') {
            usort($orders, fn($a, $b) => ($b['biaya_kunjungan'] ?? 0) <=> ($a['biaya_kunjungan'] ?? 0));
        } elseif ($sort === 'price_asc') {
            usort($orders, fn($a, $b) => ($a['biaya_kunjungan'] ?? 0) <=> ($b['biaya_kunjungan'] ?? 0));
        }

        $statusList = ['Menunggu','Dikonfirmasi','Teknisi Berangkat','Sedang Dikerjakan','Selesai','Dibatalkan'];

        return view('orders.index', compact('orders', 'filterStatus', 'statusList', 'sort'));
    }

    /** GET /orders/{id} */
    public function show(int $id)
    {
        $res   = ApiHelper::get("/order/{$id}");
        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Pesanan tidak ditemukan.', 'error');
            return redirect()->route('orders.index');
        }
        $order = ApiHelper::extractData($res, 'order', []);

        // Ambil evidence jika ada nego
        $evidence = [];
        if (!empty($order['id_nego'])) {
            $evRes    = ApiHelper::get("/evidence/{$order['id_nego']}");
            $evidence = ApiHelper::extractData($evRes, 'evidence', []);
        }

        // Daftar teknisi untuk form assign (Hanya untuk Admin)
        $techs = [];
        if (session('servizz_user.role') === 'Admin') {
            $techRes = ApiHelper::get('/technicians?status=Terverifikasi');
            $techs   = ApiHelper::extractData($techRes, 'technicians', []);
        }

        return view('orders.show', compact('order', 'evidence', 'techs'));
    }

    /** POST /orders/{id}/assign */
    public function assign(Request $request, int $id)
    {
        $request->validate(['id_tech' => 'required|integer']);

        $res = ApiHelper::patch("/order/{$id}/assign", ['id_tech' => (int) $request->id_tech]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal menugaskan teknisi.', 'error');
        } else {
            ApiHelper::flash('Teknisi berhasil ditugaskan.');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/{id}/status */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|string']);

        $res = ApiHelper::patch("/order/{$id}/status", ['status' => $request->status]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengubah status.', 'error');
        } else {
            ApiHelper::flash('Status pesanan berhasil diubah menjadi "' . $request->status . '".');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/{id}/nego (Khusus Mitra) */
    public function storeNego(Request $request, int $id)
    {
        $request->validate([
            'deskripsi_kerusakan' => 'required|string',
            'harga_barang'        => 'required|numeric|min:0',
            'biaya_jasa'          => 'required|numeric|min:0',
        ]);

        $res = ApiHelper::post('/nego/create', [
            'order_id'            => $id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'rincian_barang'      => $request->rincian_barang ?? '',
            'harga_barang'        => (float) $request->harga_barang,
            'biaya_jasa'          => (float) $request->biaya_jasa,
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal membuat rincian biaya.', 'error');
        } else {
            ApiHelper::flash('Rincian biaya berhasil dibuat. Menunggu persetujuan pelanggan.');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/{id}/nego/update (Khusus Mitra) */
    public function updateNego(Request $request, int $id)
    {
        $request->validate([
            'deskripsi_kerusakan' => 'nullable|string',
            'harga_barang'        => 'required|numeric|min:0',
            'biaya_jasa'          => 'required|numeric|min:0',
        ]);

        $res = ApiHelper::patch('/nego/update-price', [
            'order_id'            => $id,
            'item_price'          => (float) $request->harga_barang,
            'service_fee'         => (float) $request->biaya_jasa,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'rincian_barang'      => $request->rincian_barang ?? '',
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal memperbarui rincian biaya.', 'error');
        } else {
            ApiHelper::flash('Rincian biaya berhasil diperbarui.');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/{id}/evidence (Khusus Mitra) */
    public function storeEvidence(Request $request, int $id)
    {
        $request->validate([
            'nego_id'        => 'required|integer',
            'foto_kerusakan' => 'nullable|image|max:2048',
            'foto_nota'      => 'nullable|image|max:2048',
            'deskripsi'      => 'nullable|string',
        ]);

        $fotoKerusakanUrl = null;
        $fotoNotaUrl      = null;

        if ($request->hasFile('foto_kerusakan')) {
            $file = $request->file('foto_kerusakan');
            $filename = time() . '_kerusakan_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $fotoKerusakanUrl = asset('uploads/' . $filename);
        }

        if ($request->hasFile('foto_nota')) {
            $file = $request->file('foto_nota');
            $filename = time() . '_nota_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $fotoNotaUrl = asset('uploads/' . $filename);
        }

        $res = ApiHelper::post('/evidence', [
            'nego_id'        => (int) $request->nego_id,
            'foto_kerusakan' => $fotoKerusakanUrl,
            'foto_nota'      => $fotoNotaUrl,
            'deskripsi'      => $request->deskripsi ?? '',
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengunggah bukti.', 'error');
        } else {
            ApiHelper::flash('Bukti perbaikan berhasil diunggah.');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/create (Khusus Pelanggan) */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'    => 'required|integer',
            'tgl_kunjungan' => 'required|string',
            'catatan'       => 'nullable|string',
            'lat'           => 'required|numeric',
            'long'          => 'required|numeric',
        ]);

        $tglKunjungan = $request->tgl_kunjungan;
        if (str_contains($tglKunjungan, 'T')) {
            $tglKunjungan = str_replace('T', ' ', $tglKunjungan) . ':00';
        }

        $res = ApiHelper::post('/order/create', [
            'service_id'        => (int) $request->service_id,
            'lat'               => (float) $request->lat,
            'long'              => (float) $request->long,
            'tgl_kunjungan'     => $tglKunjungan,
            'catatan'           => $request->catatan ?? '',
            'metode_pembayaran' => $request->metode_pembayaran ?? 'Transfer Bank',
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal membuat pesanan.', 'error');
            return redirect()->back();
        }

        ApiHelper::flash('Pesanan Anda berhasil dibuat!');
        return redirect()->route('orders.index');
    }

    /** POST /orders/{id}/nego/decide (Khusus Pelanggan) */
    public function decideNego(Request $request, int $id)
    {
        $request->validate([
            'nego_id'     => 'required|integer',
            'is_approved' => 'required|string', // "1" or "0"
        ]);

        $isApproved = $request->is_approved === '1';

        $res = ApiHelper::post('/nego/approve', [
            'nego_id'     => (int) $request->nego_id,
            'is_approved' => $isApproved,
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal memproses persetujuan.', 'error');
        } else {
            $statusMsg = $isApproved ? 'disetujui' : 'ditolak';
            ApiHelper::flash('Rincian biaya berhasil ' . $statusMsg . '.');
        }

        return redirect()->route('orders.show', $id);
    }

    /** POST /orders/{id}/rating (Khusus Pelanggan) */
    public function submitRating(Request $request, int $id)
    {
        $request->validate([
            'nilai'    => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $res = ApiHelper::post("/order/{$id}/rating", [
            'nilai'    => (int) $request->nilai,
            'komentar' => $request->komentar ?? '',
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal mengirimkan rating.', 'error');
        } else {
            ApiHelper::flash('Terima kasih! Rating Anda berhasil dikirimkan.');
        }

        return redirect()->route('orders.show', $id);
    }
}