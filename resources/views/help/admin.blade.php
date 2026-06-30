{{-- Lokasi: resources/views/help/admin.blade.php --}}
@extends('layouts.app')
@section('title', 'Pusat Bantuan - Admin')
@section('breadcrumb', 'Pusat Bantuan')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pesan Bantuan Pengguna</h2>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] overflow-hidden">
        @if($tickets->isEmpty())
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <i class="bi bi-inbox text-4xl mb-3 block"></i>
                Belum ada pesan bantuan dari pengguna.
            </div>
        @else
            <div class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                @foreach($tickets as $ticket)
                    <div class="p-6 transition-colors hover:bg-gray-50 dark:hover:bg-[#1f1f1e]">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user_name) }}&background=random" class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $ticket->user_name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($ticket->created_at)->locale('id')->isoFormat('D MMM Y, HH:mm') }}</p>
                                </div>
                            </div>
                            @if($ticket->is_resolved)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500">Dijawab</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu Balasan</span>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-200 dark:border-[#3E3E3A] text-sm text-gray-800 dark:text-gray-300 mb-4">
                            {{ $ticket->message }}
                        </div>

                        @if($ticket->is_resolved)
                            <div class="ml-8 border-l-2 border-primary pl-4 py-2">
                                <h5 class="text-xs font-bold text-primary uppercase tracking-wider mb-2">Balasan Admin</h5>
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $ticket->admin_reply }}
                                </div>
                                <div class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($ticket->updated_at)->diffForHumans() }}</div>
                            </div>
                        @else
                            <div x-data="{ showReply: false }">
                                <button @click="showReply = !showReply" x-show="!showReply" class="text-sm font-medium text-primary hover:text-primary-600 dark:hover:text-primary-400 flex items-center gap-1">
                                    <i class="bi bi-reply"></i> Balas Pesan
                                </button>
                                
                                <form x-show="showReply" method="POST" action="{{ route('help.admin.reply', $ticket->id) }}" class="mt-3 m-0">
                                    @csrf
                                    <textarea name="reply" rows="3" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#161615] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white mb-3" placeholder="Tulis balasan untuk pengguna ini..." required></textarea>
                                    <div class="flex gap-2 justify-end">
                                        <button type="button" @click="showReply = false" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Batal</button>
                                        <button type="submit" class="bg-primary text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm shadow-primary/30">Kirim Balasan</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
