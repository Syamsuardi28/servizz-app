@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
@php
    $totalOrders = $stats['total_order'] ?? 0;
    $orderWait = $stats['order_menunggu'] ?? 0;
    $orderDone = $stats['order_selesai'] ?? 0;
    $totalRev = $stats['total_revenue'] ?? 0;
@endphp

<!-- STATS GRID -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <x-card class="hover:border-blue-500/30 transition-colors cursor-pointer" onclick="window.location.href='{{ route('orders.index') }}'">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesanan Baru</span>
            <div class="p-2 rounded-xl bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">{{ number_format($totalOrders, 0, ',', '.') }}</div>
        <div class="mt-4 flex items-center text-xs">
            <x-badge variant="info"><i data-lucide="calendar" class="w-3 h-3 mr-1"></i> Hari Ini</x-badge>
            <span class="ml-2 text-gray-400 dark:text-gray-500 font-medium">Total hari ini</span>
        </div>
    </x-card>

    <x-card class="hover:border-amber-500/30 transition-colors cursor-pointer" onclick="window.location.href='{{ route('orders.index', ['status' => 'Menunggu']) }}'">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu</span>
            <div class="p-2 rounded-xl bg-amber-50 text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                <i data-lucide="hourglass" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">{{ number_format($orderWait, 0, ',', '.') }}</div>
        <div class="mt-4 flex items-center text-xs">
            <x-badge variant="warning"><i data-lucide="loader" class="w-3 h-3 mr-1 animate-spin"></i> Proses</x-badge>
            <span class="ml-2 text-gray-400 dark:text-gray-500 font-medium">Perlu diproses</span>
        </div>
    </x-card>

    <x-card class="hover:border-green-500/30 transition-colors cursor-pointer" onclick="window.location.href='{{ route('orders.index', ['status' => 'Selesai']) }}'">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai</span>
            <div class="p-2 rounded-xl bg-green-50 text-green-500 group-hover:bg-green-500 group-hover:text-white transition-colors">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">{{ number_format($orderDone, 0, ',', '.') }}</div>
        <div class="mt-4 flex items-center text-xs">
            <x-badge variant="success"><i data-lucide="check-check" class="w-3 h-3 mr-1"></i> Selesai</x-badge>
            <span class="ml-2 text-gray-400 dark:text-gray-500 font-medium">Total Riwayat</span>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendapatan</span>
            <div class="p-2 rounded-xl bg-primary-50 text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading text-xl break-all">Rp {{ number_format($totalRev, 0, ',', '.') }}</div>
        <div class="mt-4 flex items-center text-xs">
            <x-badge variant="primary"><i data-lucide="banknote" class="w-3 h-3 mr-1"></i> Total</x-badge>
            <span class="ml-2 text-gray-400 dark:text-gray-500 font-medium">Seluruh Pendapatan</span>
        </div>
    </x-card>
</div>

<!-- CHARTS ROW -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <x-card class="lg:col-span-2 h-[400px]">
        <x-slot name="header">
            <h3 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Tren Pesanan</h3>
            <span class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-[#262625] rounded-lg">Tahun Ini</span>
        </x-slot>
        <div class="flex-1 min-h-0 w-full relative">
            <canvas id="occupancyChart"></canvas>
        </div>
    </x-card>

    <x-card class="h-[400px]">
        <x-slot name="header">
            <h3 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Kategori Jasa</h3>
        </x-slot>
        
        <div class="flex justify-between items-center mb-4" id="platformLegend">
            <!-- Injected by JS -->
        </div>

        <div class="flex-1 min-h-0 w-full relative flex items-center justify-center">
            <canvas id="platformChart"></canvas>
        </div>
    </x-card>
</div>

<!-- BOTTOM SECTIONS -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- LEFT/MAIN -->
    <div class="xl:col-span-2 space-y-6">
        
        <x-card>
            <x-slot name="header">
                <h3 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Pesanan Terbaru</h3>
                <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Lihat semua</a>
            </x-slot>
            
            <div class="overflow-x-auto -mx-6 -my-6">
                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-[#1f1f1e] text-gray-500 dark:text-gray-400 font-semibold border-b border-gray-100 dark:border-[#3E3E3A] uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                        @foreach($recentOrders as $ro)
                        <tr class="hover:bg-gray-50/50 dark:bg-[#1f1f1e]/50 dark:hover:bg-[#262625]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-[#EDEDEC]">#{{ $ro['id_order'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($ro['nama_pelanggan']) }}&background=ffe1db&color=F53003&bold=true" class="w-8 h-8 rounded-full">
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $ro['nama_pelanggan'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 dark:bg-[#262625] text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($ro['tgl_kunjungan'])->locale('id')->diffForHumans() }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('orders.show', $ro['id_order']) }}" class="text-gray-400 dark:text-gray-500 hover:text-primary-600 transition-colors">
                                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-card>
            <x-slot name="header">
                <h3 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Jadwal Kunjungan Mendatang</h3>
            </x-slot>
            
            <div class="overflow-x-auto -mx-6 -my-6">
                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-[#1f1f1e] text-gray-500 dark:text-gray-400 font-semibold border-b border-gray-100 dark:border-[#3E3E3A] uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Jadwal</th>
                            <th class="px-6 py-4">Jasa & Pelanggan</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                        @forelse($calendarBookings as $cb)
                        <tr class="hover:bg-gray-50/50 dark:bg-[#1f1f1e]/50 dark:hover:bg-[#262625]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-[#EDEDEC]">#{{ $cb['id_order'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400">
                                    {{ \Carbon\Carbon::parse($cb['tgl_kunjungan'])->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $cb['nama_service'] }}</div>
                                <div class="text-xs mt-0.5">{{ $cb['nama_pelanggan'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('orders.show', $cb['id_order']) }}" class="text-gray-400 dark:text-gray-500 hover:text-primary-600 transition-colors">
                                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada jadwal kunjungan mendatang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="space-y-6">
        
        <x-card class="bg-gradient-to-br from-primary-500 to-primary-600 text-white border-none shadow-primary-500/20">
            <h3 class="text-sm font-bold text-white/80 font-heading mb-4">Total Pendapatan</h3>
            <div class="text-3xl font-extrabold tracking-tight mb-6">Rp {{ number_format($totalRev, 0, ',', '.') }}</div>
            
            <div class="space-y-4">
                @php
                    $colors = ['bg-white dark:bg-[#161615]', 'bg-white/70', 'bg-white/40', 'bg-white/20'];
                    $maxRev = isset($topPartners[0]) ? $topPartners[0]['total_revenue'] : 1;
                    if ($maxRev <= 0) $maxRev = 1;
                @endphp
                @foreach($topPartners as $index => $partner)
                    @php
                        $pct = ($partner['total_revenue'] / $maxRev) * 100;
                        $col = $colors[$index % count($colors)];
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="truncate pr-2">{{ $partner['nama'] }}</span>
                            <span>{{ round($pct) }}%</span>
                        </div>
                        <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden">
                            <div class="h-full {{ $col }} rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-primary-500"></i>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Tugas Verifikasi</h3>
                </div>
            </x-slot>
            
            <div class="space-y-4">
                @forelse($pendingTasks as $pt)
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 dark:border-[#3E3E3A] hover:border-primary-100 hover:bg-primary-50/50 transition-colors">
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ \Carbon\Carbon::parse($pt['created_at'])->locale('id')->diffForHumans() }}
                        </div>
                        <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $pt['nama'] }}</div>
                    </div>
                    <a href="{{ route('technicians.show', $pt['id_tech']) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 bg-primary-100 rounded-lg hover:bg-primary-200 transition-colors">Tinjau</a>
                </div>
                @empty
                <div class="text-center py-6">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-500 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]">Semua beres!</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tidak ada mitra yang menunggu verifikasi.</p>
                </div>
                @endforelse
            </div>
        </x-card>

    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($charts ?? []);
    
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.plugins.tooltip.backgroundColor = '#1f2937';
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;

    // 1. OCCUPANCY CHART (Line with Area)
    const occCtx = document.getElementById('occupancyChart').getContext('2d');
    let gradientFill = occCtx.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, 'rgba(245, 48, 3, 0.2)'); // Primary-500 with opacity
    gradientFill.addColorStop(1, 'rgba(245, 48, 3, 0)');

    let oLabels = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
    let oData = [18, 18, 65, 65, 82, 82, 75];
    
    if (chartData.orderTrends && chartData.orderTrends.length > 0) {
        oData = [];
        oLabels = [];
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        chartData.orderTrends.forEach(r => {
            let mName = r.month >= 1 && r.month <= 12 ? monthNames[r.month - 1] : 'M' + r.month;
            oLabels.push(mName);
            oData.push(r.total_pesanan);
        });
    }

    new Chart(occCtx, {
        type: 'line',
        data: {
            labels: oLabels,
            datasets: [{
                label: 'Pesanan',
                data: oData,
                borderColor: '#F53003',
                backgroundColor: gradientFill,
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#F53003',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6', drawBorder: false, borderDash: [4, 4] },
                    border: { display: false },
                    ticks: { precision: 0 }
                },
                x: {
                    grid: { display: false },
                    border: { display: false }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });

    // 2. PLATFORM CHART (Doughnut)
    const platCtx = document.getElementById('platformChart').getContext('2d');
    let pLabels = ['AC', 'Elektronik', 'Pipa', 'Kelistrikan'];
    let pData = [45, 25, 20, 10];
    let pColors = ['#F53003', '#ff6d51', '#ffa28e', '#ffe1db']; // Monochrome Primary

    if (chartData.serviceStats && chartData.serviceStats.length > 0) {
        pLabels = chartData.serviceStats.map(s => s.label);
        pData = chartData.serviceStats.map(s => s.value);
    }

    new Chart(platCtx, {
        type: 'doughnut',
        data: {
            labels: pLabels,
            datasets: [{
                data: pData,
                backgroundColor: pColors,
                borderWidth: 0,
                cutout: '75%',
                borderRadius: 4,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    // Inject Legend Platform
    let legendHtml = '';
    let totalPData = pData.reduce((a, b) => a + Number(b), 0);
    pLabels.forEach((l, i) => {
        if(i > 2) return; // limit to top 3 for space
        let color = pColors[i % pColors.length];
        let val = Number(pData[i]);
        let pct = totalPData > 0 ? Math.round((val / totalPData) * 100) : 0;
        legendHtml += `
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:${color}"></div>
                <div class="text-xs text-gray-500 dark:text-gray-400 font-semibold capitalize">${l}</div>
            </div>
        `;
    });
    document.getElementById('platformLegend').innerHTML = legendHtml;
});
</script>
@endsection
