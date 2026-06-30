@extends('layouts.app')

@section('title', 'Bantuan & Dukungan')
@section('breadcrumb', 'Bantuan')

@section('content')
<div class="flex flex-col h-[calc(100vh-140px)] max-h-[800px] bg-white dark:bg-[#161615] rounded-3xl shadow-lg border border-gray-100 dark:border-[#3E3E3A] overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-gray-100 dark:border-[#3E3E3A] bg-gray-50/80 dark:bg-[#1f1f1e]/80 backdrop-blur-md flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold text-xl font-heading ring-2 ring-white dark:ring-[#161615]">
                    AS
                </div>
                <div class="absolute bottom-0.5 right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-[#161615] rounded-full"></div>
            </div>
            <div>
                <div class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Admin Support</div>
                <div class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-[#262625] rounded-xl transition-colors">
                <i data-lucide="phone" class="w-5 h-5"></i>
            </button>
            <button class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-[#262625] rounded-xl transition-colors">
                <i data-lucide="video" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    {{-- Body --}}
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 bg-gray-50/30 dark:bg-[#0a0a0a]/20" id="chatBody">
        {{-- Loader --}}
        <div class="flex justify-center items-center h-full text-gray-400 text-sm font-medium" id="chatLoader">
            <i data-lucide="loader" class="w-6 h-6 animate-spin mr-2 text-primary-500"></i> Memuat obrolan...
        </div>
    </div>

    {{-- Footer --}}
    <div class="p-4 sm:p-5 bg-white dark:bg-[#1f1f1e] border-t border-gray-100 dark:border-[#3E3E3A]">
        <form id="chatForm" class="flex items-end gap-3 max-w-5xl mx-auto relative">
            <button type="button" class="p-3 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-[#262625] rounded-full transition-colors flex-shrink-0 focus:outline-none" title="Lampirkan File">
                <i data-lucide="paperclip" class="w-5 h-5"></i>
            </button>
            <div class="flex-1 relative flex items-center bg-gray-100 dark:bg-[#161615] border border-transparent dark:border-[#3E3E3A] rounded-full focus-within:ring-2 focus-within:ring-primary-500/30 focus-within:border-primary-500 transition-all overflow-hidden pr-2">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda di sini..." autocomplete="off" required
                    class="w-full bg-transparent border-none text-gray-900 dark:text-[#EDEDEC] text-sm py-3.5 pl-5 pr-2 focus:ring-0 placeholder-gray-500 dark:placeholder-gray-400">
                <button type="submit" id="sendBtn" class="flex-shrink-0 p-2.5 bg-primary-600 text-white rounded-full hover:bg-primary-700 hover:shadow-md hover:shadow-primary-500/20 transition-all focus:outline-none transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="send" class="w-4 h-4 ml-0.5"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const chatBody = document.getElementById('chatBody');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');
    const chatLoader = document.getElementById('chatLoader');

    const currentUserId = {{ session('servizz_user.id_user') ?? session('servizz_user.id_mitra') ?? 'null' }};

    function formatTime(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    function renderMessage(msg) {
        if (!msg || !msg.content) return;
        const isMe = msg.sender_id === currentUserId;
        
        const wrapper = document.createElement('div');
        wrapper.className = `flex flex-col w-full ${isMe ? 'items-end' : 'items-start'} mb-4 animate-fade-in`;
        
        wrapper.innerHTML = `
            <div class="flex flex-col ${isMe ? 'items-end' : 'items-start'} max-w-[85%] sm:max-w-[70%]">
                <div class="px-5 py-3 text-[15px] leading-relaxed shadow-sm ${isMe ? 'bg-primary-600 text-white rounded-2xl rounded-br-sm shadow-primary-500/20' : 'bg-white dark:bg-[#262625] text-gray-800 dark:text-gray-200 rounded-2xl rounded-bl-sm border border-gray-100 dark:border-[#3E3E3A]'}">
                    ${msg.content.replace(/\n/g, '<br>')}
                </div>
                <div class="text-[11px] text-gray-400 dark:text-gray-500 mt-1.5 flex items-center gap-1.5 font-medium px-1">
                    ${formatTime(msg.created_at)}
                    ${isMe ? '<i data-lucide="check-check" class="w-3.5 h-3.5 text-primary-500"></i>' : ''}
                </div>
            </div>
        `;
        
        chatBody.appendChild(wrapper);
        if (typeof lucide !== 'undefined') {
            lucide.createIcons({ root: wrapper });
        }
        chatBody.scrollTop = chatBody.scrollHeight;
    }

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
            
            // Only re-render if count changes to avoid flicker, or just re-render all for simplicity if small
            // We'll re-render all for now, but in production consider appending only new ones
            chatBody.innerHTML = ''; 

            if (response.success && response.data && response.data.length > 0) {
                response.data.forEach(msg => renderMessage(msg));
            } else {
                chatBody.innerHTML = '<div class="flex flex-col items-center justify-center h-full text-center mt-10 space-y-3"><div class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/20 text-primary-500 flex items-center justify-center"><i data-lucide="message-square" class="w-6 h-6"></i></div><div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Mulai obrolan dengan Admin Support.</div></div>';
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        } catch (error) {
            console.error("Gagal mengambil pesan", error);
            if(chatLoader) chatLoader.innerHTML = '<div class="text-red-500"><i data-lucide="alert-circle" class="w-5 h-5 inline mr-1"></i> Gagal memuat obrolan.</div>';
        }
    }

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if(!text) return;

        chatInput.value = '';
        sendBtn.disabled = true;
        sendBtn.classList.add('opacity-50', 'cursor-not-allowed');

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
            
            if (response.success && response.data) {
                if(chatBody.innerHTML.includes('Mulai obrolan')) {
                    chatBody.innerHTML = '';
                }
                renderMessage(response.data);
            }
        } catch (error) {
            console.error("Gagal mengirim pesan", error);
        } finally {
            sendBtn.disabled = false;
            sendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            chatInput.focus();
        }
    });

    document.addEventListener('DOMContentLoaded', fetchMessages);
    setInterval(fetchMessages, 5000);
</script>
<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
