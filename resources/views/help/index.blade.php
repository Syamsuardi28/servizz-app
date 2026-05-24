@extends('layouts.app')

@section('title', 'Bantuan & Dukungan')
@section('breadcrumb', 'Bantuan')

@push('styles')
<style>
/* WhatsApp-like Chat UI */
.chat-container {
    max-width: 900px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    height: 75vh;
    min-height: 500px;
    overflow: hidden;
}

/* Chat Header */
.chat-header {
    display: flex;
    align-items: center;
    padding: 16px 24px;
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
}
.chat-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    margin-right: 16px;
    object-fit: cover;
}
.chat-info {
    flex: 1;
}
.chat-name {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2px;
}
.chat-status {
    font-size: 13px;
    color: #64748b;
}
.chat-header-actions {
    display: flex;
    gap: 16px;
    color: #475569;
    font-size: 20px;
}

/* Chat Body */
.chat-body {
    flex: 1;
    padding: 24px;
    background: #fafafa;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Bubbles */
.chat-bubble-wrapper {
    display: flex;
    flex-direction: column;
    max-width: 70%;
}
.chat-bubble-wrapper.left {
    align-self: flex-start;
}
.chat-bubble-wrapper.right {
    align-self: flex-end;
    align-items: flex-end;
}
.chat-bubble {
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 14.5px;
    line-height: 1.5;
    position: relative;
    word-wrap: break-word;
}
.chat-bubble.left {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    color: #334155;
    border-top-left-radius: 2px;
}
.chat-bubble.right {
    background: #ece8f9;
    color: #1e293b;
    border-top-right-radius: 2px;
}
.chat-time {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 4px;
}

/* Chat Input Footer */
.chat-footer {
    display: flex;
    align-items: center;
    padding: 16px 24px;
    background: #ffffff;
    border-top: 1px solid #f1f5f9;
    gap: 12px;
}
.chat-attach-btn {
    color: #94a3b8;
    font-size: 20px;
    cursor: pointer;
}
.chat-input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 8px 16px;
}
.chat-input-wrapper input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 14.5px;
    color: #334155;
    font-family: inherit;
}
.chat-input-wrapper input::placeholder {
    color: #cbd5e1;
}
.chat-send-btn {
    background: transparent;
    border: none;
    color: #6366f1;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}
.chat-send-btn:hover {
    color: #4f46e5;
}
</style>
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
