@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('breadcrumb', 'Pengguna')

@section('content')
@php
    $totalPelanggan = count(array_filter($users, fn($u) => $u['role'] === 'Pelanggan'));
    $totalMitra     = count(array_filter($users, fn($u) => $u['role'] === 'Mitra'));
    $totalActive    = count(array_filter($users, fn($u) => $u['is_active']));
    $totalAll       = count($users);
    $activePercent  = $totalAll > 0 ? round(($totalActive / $totalAll) * 100) : 0;
@endphp

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Data Pengguna</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola seluruh pengguna (pelanggan & mitra) yang terdaftar pada sistem.</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Total Pelanggan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalPelanggan }}</p>
        </div>
    </div>
    
    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
            <i data-lucide="briefcase" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Total Mitra</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalMitra }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-2xl p-5 border border-gray-100 dark:border-[#3E3E3A] shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
            <i data-lucide="user-check" class="w-6 h-6"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-0.5">Pengguna Aktif</p>
            <div class="flex items-center gap-2">
                <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] leading-none">{{ $totalActive }}</p>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                    {{ $activePercent }}%
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
    <div class="flex overflow-x-auto gap-2 pb-2 sm:pb-0 hide-scrollbar w-full sm:w-auto p-1 bg-gray-50 dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] rounded-xl">
        <a href="{{ route('users.index') }}" class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold transition-all {{ !$role ? 'bg-white dark:bg-[#262625] text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Semua</a>
        <a href="{{ route('users.index', ['role' => 'Pelanggan']) }}" class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $role === 'Pelanggan' ? 'bg-white dark:bg-[#262625] text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Pelanggan</a>
        <a href="{{ route('users.index', ['role' => 'Mitra']) }}" class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $role === 'Mitra' ? 'bg-white dark:bg-[#262625] text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Mitra</a>
    </div>

    <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative flex-1 md:w-64">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500"></i>
            <input type="text" id="userSearch" placeholder="Cari pengguna..." class="w-full pl-9 pr-4 py-2 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 shadow-sm transition-shadow">
        </div>
        <button onclick="window.location.reload()" class="p-2.5 text-gray-500 dark:text-gray-400 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl hover:bg-gray-50 dark:hover:bg-[#262625] dark:bg-[#1f1f1e] hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
        </button>
    </div>
</div>

<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($users as $u)
        @php
            $initial = strtoupper(substr($u['nama'] ?? 'U', 0, 1));
            $noHp = $u['no_hp'] ?? '';
            $waLink = $noHp ? 'https://wa.me/' . preg_replace('/^0/', '62', $noHp) : '#';
            $bgGrad = $u['role'] === 'Pelanggan' ? 'from-blue-500 to-indigo-600' : 'from-amber-500 to-orange-600';
        @endphp
        
        <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] flex flex-col p-6 items-center text-center group transition-all duration-300 hover:shadow-md hover:border-primary-200 dark:hover:border-primary-500/30 ats-u-card relative">
            
            <!-- Status Badge (Top Right) -->
            <div class="absolute top-4 right-4 flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $u['is_active'] ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20' : 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20' }}">
                <div class="w-1.5 h-1.5 rounded-full {{ $u['is_active'] ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                {{ $u['is_active'] ? 'Aktif' : 'Nonaktif' }}
            </div>

            <a href="{{ route('users.show', $u['id_user']) }}" class="block mb-4 mt-2">
                <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br {{ $bgGrad }} text-white flex items-center justify-center text-3xl font-bold font-heading shadow-md ring-4 ring-white dark:ring-[#161615]">
                    {{ $initial }}
                </div>
            </a>

            <h3 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading leading-tight line-clamp-1">{{ $u['nama'] }}</h3>
            <p class="text-sm font-semibold text-primary-600 dark:text-primary-400 mt-1">{{ $u['role'] }}</p>

            <!-- Stats/Icons -->
            <div class="w-full mt-5 space-y-3 border-t border-gray-100 dark:border-[#3E3E3A] pt-4 text-sm">
                <div class="flex justify-between items-center text-left bg-gray-50/50 dark:bg-[#1f1f1e] p-2.5 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400 font-medium text-xs uppercase tracking-wide flex items-center gap-1"><i data-lucide="mail" class="w-3.5 h-3.5"></i> Email</span>
                    <span class="font-bold text-gray-900 dark:text-[#EDEDEC] text-right truncate max-w-[120px]" title="{{ $u['email'] }}">{{ Str::limit($u['email'], 12) }}</span>
                </div>
                <div class="flex justify-between items-center text-left bg-gray-50/50 dark:bg-[#1f1f1e] p-2.5 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400 font-medium text-xs uppercase tracking-wide flex items-center gap-1"><i data-lucide="phone" class="w-3.5 h-3.5"></i> HP</span>
                    <span class="font-bold text-gray-900 dark:text-[#EDEDEC] text-right">{{ $noHp ? $noHp : '-' }}</span>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 w-full mt-6">
                <a href="{{ $waLink }}" target="{{ $noHp ? '_blank' : '_self' }}" onclick="{{ !$noHp ? 'alert(\'Nomor HP tidak tersedia\'); return false;' : '' }}" class="flex-1 inline-flex justify-center items-center gap-1.5 px-3 py-2.5 text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-[#262625] border border-gray-200 dark:border-[#3E3E3A] rounded-xl hover:bg-gray-100 dark:hover:bg-[#3E3E3A] transition-colors">
                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Hubungi
                </a>
                
                <form method="POST" action="{{ route('users.toggle', $u['id_user']) }}" class="flex-1" x-data @submit.prevent="confirmToggle($event, $el, '{{ $u['is_active'] ? 'menonaktifkan' : 'mengaktifkan' }}', '{{ addslashes($u['nama']) }}')">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-1.5 px-3 py-2.5 text-xs font-bold rounded-xl transition-colors {{ $u['is_active'] ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 hover:bg-red-100 dark:hover:bg-red-500/20' : 'text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 hover:bg-emerald-100 dark:hover:bg-emerald-500/20' }}">
                        <i data-lucide="{{ $u['is_active'] ? 'power-off' : 'power' }}" class="w-3.5 h-3.5"></i> 
                        {{ $u['is_active'] ? 'Nonaktif' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] border-dashed rounded-3xl">
            <div class="w-16 h-16 bg-gray-50 dark:bg-[#1f1f1e] text-gray-400 dark:text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users-2" class="w-8 h-8"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Tidak ada pengguna</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tidak ditemukan data pengguna untuk peran ini.</p>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmToggle(event, formElement, actionName, userName) {
    Swal.fire({
        title: 'Konfirmasi',
        text: `Apakah Anda yakin ingin ${actionName} akun ${userName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F53003',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl border border-gray-100 dark:border-[#3E3E3A] shadow-xl',
            confirmButton: 'rounded-xl text-sm font-bold',
            cancelButton: 'rounded-xl text-sm font-bold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            formElement.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    if(searchInput) {
        searchInput.addEventListener('input', function(e) {
            const val = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.ats-u-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(val) ? 'flex' : 'none';
            });
        });
    }
});
</script>
@endsection
