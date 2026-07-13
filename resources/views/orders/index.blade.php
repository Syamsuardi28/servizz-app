@extends('layouts.app')
@section('title', 'Kelola Pesanan')
@section('breadcrumb', 'Pesanan')

@section('content')

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Daftar Pesanan</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola semua pesanan layanan dari pelanggan.</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Filter Status -->
        <div class="relative">
            <select id="statusFilter" onchange="updateFilters()" class="appearance-none bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] text-gray-700 dark:text-gray-300 py-2 pl-4 pr-10 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm font-medium transition-all">
                <option value="">Semua Status</option>
                @foreach($statusList as $s)
                    <option value="{{ $s }}" {{ $filterStatus === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </div>
        </div>

        <!-- Download/Export Button -->
        <x-button variant="secondary" icon="download" onclick="exportData()">Unduh Data</x-button>

        @if(session('servizz_user.role') === 'Pelanggan')
            <x-button variant="primary" icon="plus" onclick="window.location.href='{{ route('services.index') }}'">Buat Pesanan</x-button>
        @else
            <x-button variant="secondary" icon="refresh-cw" onclick="window.location.href='{{ route('orders.index') }}'">Refresh</x-button>
        @endif
    </div>
</div>

<!-- Table Card -->
<x-card class="p-0">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
            <thead class="bg-gray-50 dark:bg-[#1f1f1e] text-gray-500 dark:text-gray-400 font-semibold border-b border-gray-100 dark:border-[#3E3E3A] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 w-12"><input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"></th>
                    <th class="px-6 py-4">Proyek & Pelanggan</th>
                    <th class="px-6 py-4">Tgl & Waktu</th>
                    <th class="px-6 py-4">Biaya</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Partisipan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                @forelse($orders as $index => $o)
                    @php
                        $st = $o['status_order'];
                        $badgeVariant = 'gray';
                        if ($st === 'Selesai') $badgeVariant = 'success';
                        elseif ($st === 'Menunggu') $badgeVariant = 'warning';
                        elseif ($st === 'Dikonfirmasi') $badgeVariant = 'info';
                        elseif ($st === 'Teknisi Berangkat') $badgeVariant = 'primary';
                        elseif ($st === 'Sedang Dikerjakan') $badgeVariant = 'primary';
                        elseif ($st === 'Dibatalkan') $badgeVariant = 'danger';

                        $iconColors = ['bg-blue-100 text-blue-600', 'bg-red-100 text-red-600', 'bg-emerald-100 text-emerald-600', 'bg-amber-100 text-amber-600', 'bg-purple-100 text-purple-600'];
                        $bg = $iconColors[$index % count($iconColors)];
                    @endphp
                <tr class="hover:bg-gray-50/50 dark:bg-[#1f1f1e]/50 dark:hover:bg-[#262625]/50 transition-colors group">
                    <td class="px-6 py-4"><input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"></td>
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $bg }}">
                                <i data-lucide="briefcase" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-[#EDEDEC] leading-tight group-hover:text-primary-600 transition-colors">{{ Str::limit($o['nama_service'], 30) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ Str::limit($o['nama_pelanggan'] ?? 'Pelanggan', 25) }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="font-semibold text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($o['tgl_kunjungan'])->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($o['waktu_kunjungan'] ?? $o['tgl_kunjungan'])->format('H:i') }} WIB</p>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900 dark:text-[#EDEDEC]">
                        Rp {{ number_format($o['biaya_kunjungan'], 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge :variant="$badgeVariant">{{ $st }}</x-badge>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center -space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($o['nama_pelanggan'] ?? 'Pelanggan') }}&background=f3f4f6&color=4b5563&bold=true" class="w-8 h-8 rounded-full border-2 border-white shadow-sm ring-2 ring-white relative z-10" title="Pelanggan: {{ $o['nama_pelanggan'] ?? 'Pelanggan' }}">
                            @if($o['nama_mitra'] ?? null)
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($o['nama_mitra']) }}&background=ffe1db&color=F53003&bold=true" class="w-8 h-8 rounded-full border-2 border-white shadow-sm ring-2 ring-white relative z-20" title="Mitra: {{ $o['nama_mitra'] }}">
                            @endif
                        </div>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('orders.show', $o['id_order']) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 dark:text-gray-500 hover:text-primary-600 hover:bg-primary-50 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 dark:bg-[#1f1f1e] text-gray-400 dark:text-gray-500 mb-4">
                            <i data-lucide="inbox" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]">Belum ada pesanan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tidak ada pesanan{{ $filterStatus ? ' dengan status '.$filterStatus : '' }} saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

@endsection

@section('scripts')
<script>
function updateFilters() {
    const status = document.getElementById('statusFilter').value;
    let url = '{{ route("orders.index") }}?';
    if(status) url += 'status=' + encodeURIComponent(status);
    window.location.href = url;
}

function exportData() {
    const status = document.getElementById('statusFilter').value;
    let url = '{{ route("orders.export") }}?';
    if(status) url += 'status=' + encodeURIComponent(status);
    window.location.href = url;
}
</script>
@endsection
