<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Memulai pembayaran biaya kunjungan melalui Midtrans
     */
    public function charge(Request $request, int $id)
    {
        // Panggil API Node.js untuk mendapatkan Snap Token / Redirect URL
        $res = ApiHelper::post('/payment/charge', [
            'order_id'     => $id,
            'payment_type' => $request->input('payment_type', 'bank_transfer')
        ]);

        if (!$res['success']) {
            ApiHelper::flash($res['data']['message'] ?? 'Gagal menghubungi gerbang pembayaran.', 'error');
            return redirect()->route('orders.show', $id);
        }

        // Redirect pengguna ke halaman pembayaran Midtrans
        if (!empty($res['data']['redirect_url'])) {
            return redirect()->away($res['data']['redirect_url']);
        }

        ApiHelper::flash('Terjadi kesalahan yang tidak diketahui dari gerbang pembayaran.', 'error');
        return redirect()->route('orders.show', $id);
    }
}
