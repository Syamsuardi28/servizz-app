@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('breadcrumb', 'Pengguna / Detail')

@section('content')

<div class="mb-6">
    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-[#EDEDEC] font-semibold text-sm transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Pengguna
    </a>
</div>

{{-- Top Section: Avatar & Bio --}}
<x-card class="mb-6 overflow-hidden">
    <div class="flex flex-col md:flex-row items-center gap-8 p-4">
        <div class="w-32 h-32 rounded-3xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-500 flex items-center justify-center text-5xl font-bold shrink-0 shadow-inner border-4 border-white dark:border-[#161615] overflow-hidden">
            @if(!empty($user['foto_profil']))
                <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ $user['foto_profil'] }}" alt="Avatar" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr($user['nama'] ?? 'U', 0, 1)) }}
            @endif
        </div>
        
        <div class="flex-1 text-center md:text-left">
            <x-badge variant="primary" class="mb-2">{{ $user['role'] ?? 'Pengguna' }}</x-badge>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-[#EDEDEC] mb-2">{{ $user['nama'] ?? 'Pengguna Servizz' }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-2xl">
                Ini adalah halaman detail untuk pengguna <strong>{{ $user['nama'] }}</strong>. Di sini Anda dapat meninjau informasi kontak yang terdaftar serta aktivitas pesanan yang melibatkan pengguna ini di dalam sistem Servizz.
            </p>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                @php 
                    $noHp = $user['no_hp'] ?? '';
                    $waLink = $noHp ? 'https://wa.me/' . preg_replace('/^0/', '62', $noHp) : '#';
                @endphp
                <a href="{{ $waLink }}" target="{{ $noHp ? '_blank' : '_self' }}" onclick="{{ !$noHp ? 'alert(\'Nomor HP tidak tersedia\'); return false;' : '' }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary-500/20 transition-all">
                    <i data-lucide="phone" class="w-4 h-4"></i> Hubungi Pengguna
                </a>
                
                <form method="POST" action="{{ route('users.toggle', $user['id_user']) }}" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin {{ $user['is_active'] ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#1f1f1e] hover:bg-gray-50 dark:hover:bg-[#262625] border border-gray-200 dark:border-[#3E3E3A] text-gray-700 dark:text-[#EDEDEC] font-bold rounded-xl shadow-sm transition-all">
                        <i data-lucide="{{ $user['is_active'] ? 'user-x' : 'user-check' }}" class="w-4 h-4 {{ $user['is_active'] ? 'text-red-500' : 'text-green-500' }}"></i>
                        {{ $user['is_active'] ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-card>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Left: Informasi Akun --}}
    <div class="xl:col-span-1 space-y-6">
        <x-card>
            <x-slot name="header">
                <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC]">Informasi Akun</h2>
            </x-slot>

            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-[#262625] flex items-center justify-center text-gray-500 dark:text-gray-400 shrink-0 border border-gray-200 dark:border-[#3E3E3A]">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Alamat E-mail</h3>
                        <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ $user['email'] ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-[#262625] flex items-center justify-center text-gray-500 dark:text-gray-400 shrink-0 border border-gray-200 dark:border-[#3E3E3A]">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Telepon / WhatsApp</h3>
                        <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ $user['no_hp'] ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-[#262625] flex items-center justify-center text-gray-500 dark:text-gray-400 shrink-0 border border-gray-200 dark:border-[#3E3E3A]">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Alamat Domisili</h3>
                        <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ $user['alamat'] ?? 'Belum ada alamat.' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-[#262625] flex items-center justify-center text-gray-500 dark:text-gray-400 shrink-0 border border-gray-200 dark:border-[#3E3E3A]">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Tanggal Registrasi</h3>
                        <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ \Carbon\Carbon::parse($user['created_at'])->locale('id')->isoFormat('D MMMM Y') }}</p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Right: Timeline Riwayat Pesanan --}}
    <div class="xl:col-span-2 space-y-6">
        <x-card>
            <x-slot name="header">
                <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC]">Aktivitas Pesanan</h2>
            </x-slot>

            <div class="relative border-l border-gray-200 dark:border-[#3E3E3A] ml-4 space-y-8 py-2">
                @forelse(array_slice($orders ?? [], 0, 10) as $idx => $order)
                    @php
                        $badgeVariant = 'gray';
                        if($order['status_order'] === 'Selesai') $badgeVariant = 'success';
                        elseif(in_array($order['status_order'], ['Sedang Dikerjakan', 'Teknisi Berangkat'])) $badgeVariant = 'primary';
                        elseif($order['status_order'] === 'Dibatalkan') $badgeVariant = 'danger';
                    @endphp
                    <div class="relative pl-8">
                        <!-- Timeline Dot -->
                        <div class="absolute -left-1.5 top-2.5 w-3 h-3 bg-gray-200 dark:bg-[#3E3E3A] rounded-full ring-4 ring-white dark:ring-[#161615]"></div>
                        
                        <div class="p-5 bg-gray-50 dark:bg-[#1f1f1e] border border-gray-100 dark:border-[#3E3E3A] rounded-xl hover:shadow-md transition-shadow">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                                <h3 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $order['nama_service'] ?? 'Layanan Servizz' }}</h3>
                                <x-badge :variant="$badgeVariant">{{ $order['status_order'] }}</x-badge>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ Str::limit($order['catatan'] ?? 'Pesanan reguler', 80) }}</p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-[#3E3E3A]">
                                <span class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]">Total: Rp {{ number_format($order['biaya_kunjungan'] ?? 0, 0, ',', '.') }}</span>
                                <a href="{{ route('orders.show', $order['id_order']) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary-500 hover:text-primary-600 transition-colors">
                                    Lihat Detail <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-gray-50 dark:bg-[#1f1f1e] rounded-xl border border-dashed border-gray-200 dark:border-[#3E3E3A] ml-8">
                        <i data-lucide="inbox" class="w-8 h-8 text-gray-400 dark:text-gray-500 mx-auto mb-3"></i>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada aktivitas pesanan untuk pengguna ini.</p>
                    </div>
                @endforelse
            </div>
        </x-card>
    </div>
</div>

@endsection
