<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiHelper;

class HelpController extends Controller
{
    /**
     * Tampilkan halaman formulir bantuan (Untuk Pelanggan/Mitra)
     */
    public function index()
    {
        return view('help.index');
    }

    /**
     * Mengambil riwayat pesan
     */
    public function getMessages()
    {
        $res = ApiHelper::get('/messages');
        return response()->json($res);
    }

    /**
     * Kirim pesan baru
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $res = ApiHelper::post('/messages', [
            'content' => $request->content,
            'receiver_id' => 1, // Default ke Admin
        ]);

        return response()->json($res);
    }

    /**
     * Tandai notifikasi dibaca (AJAX)
     */
    public function markRead($id)
    {
        $res = ApiHelper::patch("/notifications/{$id}/read", []);
        return response()->json($res);
    }
}
