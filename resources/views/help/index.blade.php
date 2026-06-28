@extends('layouts.app')

@section('title', 'Bantuan & Dukungan')
@section('breadcrumb', 'Bantuan')

@push('styles')
@endpush


@push('styles')
    @vite('resources/css/help.css')
@endpush

@section('content')
<div class="chat-container">
    {{-- Header --}}
    <div class="chat-header">
        <img src="https://ui-avatars.com/api/?name=Admin+Servizz&background=6366f1&color=fff" alt="Admin" class="chat-avatar">
        <div class="chat-info">
            <div class="chat-name">Admin Support</div>
            <div class="chat-status">Active now</div>
        </div>
        <div class="chat-header-actions">
            <i class="bi bi-telephone"></i>
            <i class="bi bi-camera-video"></i>
        </div>
    </div>

    {{-- Body --}}
    <div class="chat-body" id="chatBody">
        {{-- Loader --}}
        <div style="text-align:center; color:#94a3b8; font-size:13px;" id="chatLoader">
            Memuat obrolan...
        </div>
    </div>

    {{-- Footer --}}
    <div class="chat-footer">
        <i class="bi bi-paperclip chat-attach-btn"></i>
        <form id="chatForm" style="flex:1; display:flex; gap:12px; margin:0;">
            <div class="chat-input-wrapper">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda..." autocomplete="off" required>
            </div>
            <button type="submit" class="chat-send-btn" id="sendBtn">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const chatBody = document.getElementById('chatBody');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');
    const chatLoader = document.getElementById('chatLoader');

    const currentUserId = {{ session('servizz_user.id_user') }};

    // Fungsi untuk memformat jam (HH:mm)
    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    // Fungsi untuk me-render pesan ke layar
    function renderMessage(msg) {
        const isMe = msg.sender_id === currentUserId;
        const alignClass = isMe ? 'right' : 'left';
        
        const wrapper = document.createElement('div');
        wrapper.className = `chat-bubble-wrapper ${alignClass}`;
        
        wrapper.innerHTML = `
            <div class="chat-bubble ${alignClass}">
                ${msg.content}
            </div>
            <div class="chat-time">${formatTime(msg.created_at)}</div>
        `;
        
        chatBody.appendChild(wrapper);
        chatBody.scrollTop = chatBody.scrollHeight; // Scroll ke paling bawah
    }

    // Ambil semua pesan
    async function fetchMessages() {
        try {
            const res = await fetch("{{ route('help.messages.get') }}", {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const response = await res.json();
            
            if(chatLoader) chatLoader.remove();
            chatBody.innerHTML = ''; // Bersihkan

            if (response.success && response.data.length > 0) {
                response.data.forEach(msg => renderMessage(msg));
            } else {
                chatBody.innerHTML = '<div style="text-align:center; color:#94a3b8; font-size:13px; margin-top:20px;">Mulai obrolan dengan Admin.</div>';
            }
        } catch (error) {
            console.error("Gagal mengambil pesan", error);
            if(chatLoader) chatLoader.innerText = "Gagal memuat obrolan.";
        }
    }

    // Kirim pesan
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if(!text) return;

        // Kosongkan input dan nonaktifkan sementara
        chatInput.value = '';
        sendBtn.disabled = true;

        try {
            const res = await fetch("{{ route('help.messages.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ content: text })
            });

            const response = await res.json();
            
            if (response.success) {
                // Hapus tulisan "Mulai obrolan" jika ada
                if(chatBody.innerHTML.includes('Mulai obrolan')) {
                    chatBody.innerHTML = '';
                }
                renderMessage(response.data);
            }
        } catch (error) {
            console.error("Gagal mengirim pesan", error);
            alert("Terjadi kesalahan saat mengirim pesan.");
        } finally {
            sendBtn.disabled = false;
            chatInput.focus();
        }
    });

    // Panggil saat halaman dimuat
    document.addEventListener('DOMContentLoaded', fetchMessages);
    
    // Auto-refresh setiap 5 detik
    setInterval(fetchMessages, 5000);
</script>
@endpush
