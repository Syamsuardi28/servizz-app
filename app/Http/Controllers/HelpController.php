<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
     * Mengambil riwayat pesan (Pelanggan/Mitra)
     */
    public function getMessages()
    {
        $userId = session('servizz_user.id_user') ?? session('servizz_user.id_mitra');
        
        $messages = DB::table('help_messages')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Ubah format agar sesuai dengan UI lama yang mengharapkan data API
        $formatted = [];
        foreach ($messages as $msg) {
            // Pesan dari user
            $formatted[] = [
                'id_message' => $msg->id . '_u',
                'sender_id' => $msg->user_id,
                'content' => $msg->message,
                'created_at' => $msg->created_at
            ];
            // Balasan Admin
            if (!empty($msg->admin_reply)) {
                $formatted[] = [
                    'id_message' => $msg->id . '_a',
                    'sender_id' => 1, // ID admin
                    'content' => $msg->admin_reply,
                    'created_at' => $msg->updated_at
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }

    /**
     * Kirim pesan baru (Pelanggan/Mitra)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $userId = session('servizz_user.id_user') ?? session('servizz_user.id_mitra');
        $userName = session('servizz_user.nama');

        $id = DB::table('help_messages')->insertGetId([
            'user_id' => $userId,
            'user_name' => $userName,
            'message' => $request->content,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id_message' => $id . '_u',
                'sender_id' => $userId,
                'content' => $request->content,
                'created_at' => Carbon::now()->toISOString()
            ]
        ]);
    }

    /**
     * Halaman Admin: Daftar Pesan Bantuan
     */
    public function adminIndex()
    {
        $tickets = DB::table('help_messages')
            ->orderBy('is_resolved', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('help.admin', compact('tickets'));
    }

    /**
     * Halaman Admin: Balas Pesan
     */
    public function adminReply(Request $request, $id)
    {
        $request->validate(['reply' => 'required|string']);
        
        DB::table('help_messages')->where('id', $id)->update([
            'admin_reply' => $request->reply,
            'is_resolved' => true,
            'updated_at' => Carbon::now()
        ]);
        
        ApiHelper::flash('Balasan berhasil dikirim.');
        return redirect()->route('help.admin');
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
