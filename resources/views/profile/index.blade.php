@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb', 'Profil Saya')

@section('content')

<!-- Profile Header -->
<div class="relative bg-white dark:bg-[#161615] rounded-2xl border border-gray-100 dark:border-[#3E3E3A] shadow-sm overflow-hidden mb-8">
    <!-- Cover -->
    <div class="h-32 bg-gradient-to-r from-primary-500 to-primary-600 w-full relative">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    </div>
    
    <!-- Profile Info -->
    <div class="px-6 pb-6 sm:px-10">
        <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-16 gap-6 relative z-10">
            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-white dark:bg-[#161615] p-1.5 shadow-lg flex-shrink-0">
                <div class="w-full h-full rounded-xl bg-gray-100 dark:bg-[#262625] overflow-hidden flex items-center justify-center">
                    @if(!empty($user['foto_profil']))
                        <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ $user['foto_profil'] }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl font-bold text-gray-400 dark:text-gray-500 font-heading">{{ strtoupper(substr($user['nama'] ?? 'U', 0, 1)) }}</span>
                    @endif
                </div>
            </div>
            
            <div class="flex-1 text-center sm:text-left mb-2">
                <span class="inline-block px-2.5 py-1 bg-primary-100 text-primary-700 text-xs font-bold rounded-lg mb-2">{{ session('servizz_user.role') ?? 'Pengguna' }}</span>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-1">{{ $user['nama'] ?? 'Pengguna Servizz' }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center sm:justify-start gap-1">
                    <i data-lucide="mail" class="w-4 h-4"></i> {{ $user['email'] ?? 'Belum ada email' }}
                </p>
            </div>
            
            <div class="flex gap-3 mb-2 w-full sm:w-auto">
                <a href="{{ route('settings.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition-colors shadow-md shadow-primary-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Profil
                </a>
            </div>
        </div>
        
        <p class="mt-6 text-sm text-gray-600 dark:text-gray-400 max-w-2xl leading-relaxed text-center sm:text-left">
            Selamat datang di panel profil Servizz Anda. Pastikan informasi kontak Anda selalu valid agar layanan yang kami berikan dapat berjalan dengan maksimal. Anda dapat memperbarui informasi di halaman pengaturan akun.
        </p>
    </div>
</div>

<!-- Info Grid -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-4">Informasi Kontak & Akun</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white dark:bg-[#161615] p-5 rounded-2xl border border-gray-100 dark:border-[#3E3E3A] flex gap-4 group hover:border-primary-200 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <i data-lucide="mail" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email</h3>
                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC] break-all">{{ $user['email'] ?? 'Belum ditambahkan' }}</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#161615] p-5 rounded-2xl border border-gray-100 dark:border-[#3E3E3A] flex gap-4 group hover:border-primary-200 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                <i data-lucide="phone" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Telepon / WA</h3>
                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $user['no_hp'] ?? 'Belum ada nomor' }}</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#161615] p-5 rounded-2xl border border-gray-100 dark:border-[#3E3E3A] flex gap-4 group hover:border-primary-200 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                <i data-lucide="map-pin" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Domisili</h3>
                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC] line-clamp-2">{{ $user['alamat'] ?? 'Belum ada alamat' }}</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#161615] p-5 rounded-2xl border border-gray-100 dark:border-[#3E3E3A] flex gap-4 group hover:border-primary-200 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Gabung</h3>
                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ \Carbon\Carbon::parse($user['created_at'])->locale('id')->isoFormat('D MMM Y') }}</p>
            </div>
        </div>
        
    </div>
</div>

<!-- Timeline -->
@if(in_array(session('servizz_user.role'), ['Pelanggan', 'Mitra']))
<div>
    <div class="flex justify-between items-end mb-4">
        <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">{{ session('servizz_user.role') === 'Mitra' ? 'Riwayat Pekerjaan' : 'Aktivitas Pesanan' }}</h2>
        <a href="{{ route('orders.index') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700">Lihat Semua</a>
    </div>
    
    <div class="bg-white dark:bg-[#161615] rounded-2xl border border-gray-100 dark:border-[#3E3E3A] p-6 sm:p-8">
        <div class="relative border-l border-gray-200 dark:border-[#3E3E3A] ml-3 space-y-8">
            @forelse(array_slice($orders ?? [], 0, 5) as $idx => $order)
                @php
                    $st = $order['status_order'];
                    $badgeVariant = 'gray';
                    if ($st === 'Selesai') $badgeVariant = 'success';
                    elseif ($st === 'Menunggu') $badgeVariant = 'warning';
                    elseif (in_array($st, ['Sedang Dikerjakan', 'Teknisi Berangkat', 'Dikonfirmasi'])) $badgeVariant = 'primary';
                    elseif ($st === 'Dibatalkan') $badgeVariant = 'danger';
                @endphp
                <div class="relative pl-6">
                    <div class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-primary-500 ring-4 ring-white"></div>
                    
                    <div class="bg-gray-50/50 dark:bg-[#1f1f1e]/50 rounded-xl p-5 border border-gray-100 dark:border-[#3E3E3A] hover:border-primary-100 hover:bg-primary-50/30 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <h3 class="font-bold text-gray-900 dark:text-[#EDEDEC] text-base">{{ $order['nama_service'] ?? 'Layanan Servizz' }}</h3>
                            <x-badge :variant="$badgeVariant">{{ $st }}</x-badge>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($order['catatan'] ?? 'Pesanan reguler', 80) }}</p>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-[#3E3E3A]">
                            <span class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]">Rp {{ number_format($order['biaya_kunjungan'] ?? 0, 0, ',', '.') }}</span>
                            <a href="{{ route('orders.show', $order['id_order']) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                                Detail <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="pl-6 text-center py-8">
                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-[#262625] text-gray-400 dark:text-gray-500 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="inbox" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Belum ada aktivitas yang terekam.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endif

@endsection
