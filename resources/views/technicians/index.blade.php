@extends('layouts.app')
@section('title', 'Mitra / Teknisi')
@section('breadcrumb', 'Mitra / Teknisi')

@section('content')

@php
    $allTechs       = is_array($techs) ? $techs : [];
    $totalVerif     = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Terverifikasi'));
    $totalPending   = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Pending'));
    $totalDitolak   = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Ditolak'));
@endphp

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Data Mitra Jasa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola pendaftaran, verifikasi, dan performa mitra penyedia jasa.</p>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
            <i data-lucide="user-check" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Terverifikasi</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalVerif }}</p>
        </div>
    </div>
    
    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
            <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Pending</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalPending }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
            <i data-lucide="user-x" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Ditolak</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalDitolak }}</p>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
    <div class="flex overflow-x-auto gap-2 pb-2 sm:pb-0 hide-scrollbar w-full sm:w-auto p-1 bg-gray-50 dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] rounded-xl">
        <a href="{{ route('technicians.index') }}" class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold transition-all {{ !$filter ? 'bg-white dark:bg-[#262625] text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Semua</a>
        @foreach(['Pending', 'Terverifikasi', 'Ditolak'] as $s)
            <a href="{{ route('technicians.index', ['status' => $s]) }}" class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $filter === $s ? 'bg-white dark:bg-[#262625] text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">{{ $s }}</a>
        @endforeach
    </div>

    <div class="relative w-full sm:w-72">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500"></i>
        <input type="text" id="searchInput" placeholder="Cari teknisi..." class="w-full pl-9 pr-4 py-2.5 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 shadow-sm transition-shadow text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400">
    </div>
</div>

<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($allTechs as $t)
        @php
            $st = $t['status_verifikasi'] ?? 'Pending';
            
            $statusColors = [
                'Terverifikasi' => 'bg-emerald-100 text-emerald-700 ring-emerald-500/20',
                'Pending'       => 'bg-amber-100 text-amber-700 ring-amber-500/20',
                'Ditolak'       => 'bg-red-100 text-red-700 ring-red-500/20',
            ];
            $statusColor = $statusColors[$st] ?? $statusColors['Pending'];
            
            $bgColors = ['bg-blue-500','bg-indigo-500','bg-emerald-500','bg-amber-500','bg-purple-500','bg-cyan-500'];
            $avatarBg = $bgColors[crc32($t['nama'] ?? 'y') % count($bgColors)];
            $initials = strtoupper(substr($t['nama'] ?? 'T', 0, 1));
        @endphp
        
        <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] flex flex-col p-6 items-center text-center group transition-all duration-300 hover:shadow-md hover:border-primary-200 dark:hover:border-primary-500/30 ats-tech-card relative">
            
            @if(session('servizz_user.role') === 'Admin')
                <div class="absolute top-4 right-4" x-data="{ openOptions: false }">
                    <button @click="openOptions = !openOptions" @click.outside="openOptions = false" class="p-1.5 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-[#262625] focus:outline-none transition-colors">
                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>
                    
                    <div x-show="openOptions" x-transition.opacity class="absolute right-0 mt-1 w-40 bg-white dark:bg-[#20201f] rounded-xl shadow-xl border border-gray-100 dark:border-[#3E3E3A] py-1 z-20" style="display: none;">
                        <form method="POST" action="{{ route('technicians.verify', $t['id_tech']) }}">
                            @csrf
                            <input type="hidden" name="status" value="Terverifikasi">
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors">Set Terverifikasi</button>
                        </form>
                        <form method="POST" action="{{ route('technicians.verify', $t['id_tech']) }}">
                            @csrf
                            <input type="hidden" name="status" value="Ditolak">
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">Set Ditolak</button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="w-20 h-20 rounded-full {{ $avatarBg }} text-white flex items-center justify-center text-3xl font-bold font-heading shadow-md mb-4 ring-4 ring-white dark:ring-[#161615] relative">
                {{ $initials }}
                <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full ring-2 ring-white dark:ring-[#161615] bg-{{ $st === 'Terverifikasi' ? 'emerald' : ($st === 'Ditolak' ? 'red' : 'amber') }}-500"></span>
            </div>

            <h3 class="ats-tech-name text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading leading-tight">{{ $t['nama'] ?? '—' }}</h3>
            <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold {{ $st === 'Terverifikasi' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20' : ($st === 'Ditolak' ? 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20') }}">
                {{ $st }}
            </span>

            <div class="w-full mt-6 space-y-3 border-t border-gray-100 dark:border-[#3E3E3A] pt-4 text-sm">
                <div class="flex justify-between items-center text-left bg-gray-50/50 dark:bg-[#1f1f1e] p-2.5 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400 font-medium text-xs uppercase tracking-wide">Keahlian</span>
                    <span class="font-bold text-gray-900 dark:text-[#EDEDEC] text-right">{{ Str::limit($t['keahlian'] ?? 'Umum', 20) }}</span>
                </div>
                <div class="flex justify-between items-center text-left bg-gray-50/50 dark:bg-[#1f1f1e] p-2.5 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400 font-medium text-xs uppercase tracking-wide">Rating</span>
                    <span class="font-bold text-amber-500 flex items-center gap-1.5 bg-amber-50 dark:bg-amber-500/10 px-2 py-0.5 rounded">
                        <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-500"></i>
                        {{ number_format($t['rating_rata2'] ?? 0, 1) }}
                    </span>
                </div>
            </div>

            <div class="w-full mt-6">
                @if($st === 'Pending' && session('servizz_user.role') === 'Admin')
                    <form method="POST" action="{{ route('technicians.verify', $t['id_tech']) }}">
                        @csrf
                        <input type="hidden" name="status" value="Terverifikasi">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-sm shadow-primary-500/20 focus:ring-2 focus:ring-primary-500/50">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i> Verifikasi
                        </button>
                    </form>
                @else
                    <a href="{{ route('technicians.show', $t['id_tech']) }}" class="w-full flex items-center justify-center px-4 py-2.5 bg-gray-50 dark:bg-[#262625] hover:bg-gray-100 dark:hover:bg-[#3E3E3A] text-gray-900 dark:text-[#EDEDEC] rounded-xl font-bold transition-colors border border-gray-200 dark:border-[#3E3E3A]">
                        Lihat Detail
                    </a>
                @endif
            </div>

        </div>
    @empty
        <div class="col-span-full py-16 text-center bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] border-dashed rounded-3xl">
            <div class="w-16 h-16 bg-gray-50 dark:bg-[#1f1f1e] text-gray-400 dark:text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Tidak ada mitra</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Belum ada mitra yang mendaftar atau sesuai kriteria filter.</p>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.ats-tech-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(term)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
