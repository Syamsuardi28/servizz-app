@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* Base Layout */
body {
    background-color: #f3f4f8;
}
.complex-db {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
    width: 100%;
    min-width: 0;
}
@media (max-width: 1280px) {
    .complex-db { grid-template-columns: 1fr; }
}

.c-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* ── MAIN AREA ── */
.c-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 0;
    overflow: hidden;
}

/* 4 Stat Cards */
.c-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    min-width: 0;
}
@media (max-width: 1100px) {
    .c-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
.c-stat-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.cs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #4b5563;
    font-size: 14px;
    font-weight: 500;
}
.cs-icon {
    font-size: 18px;
}
.cs-value {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
}
.cs-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
}
.cs-badge {
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
}
.cs-badge.blue { background: #eff6ff; color: #3b82f6; }
.cs-badge.purple { background: #f3e8ff; color: #a855f7; }
.cs-badge.red { background: #fef2f2; color: #ef4444; }
.cs-sub { color: #9ca3af; }

/* Middle Row */
.c-middle-row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}
@media (max-width: 768px) {
    .c-middle-row { grid-template-columns: 1fr; }
}

.c-title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.c-title {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.c-btn-dropdown {
    padding: 4px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 12px;
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Bottom Row */
.c-bottom-row {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 20px;
}
.c-bottom-row > div {
    min-width: 0; /* Mencegah blowout grid */
}
@media (max-width: 768px) {
    .c-bottom-row { grid-template-columns: 1fr; }
}

/* Revenue Overview */
.rev-total-box {
    margin-bottom: 24px;
}
.rev-label { font-size: 13px; font-weight: 600; color: #111827; }
.rev-val { font-size: 24px; font-weight: 700; color: #111827; margin-top: 4px; }
.rev-split {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 24px;
}
.rev-split-item { display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9; }
.rs-left { display: flex; align-items: center; gap: 12px; }
.rs-icon { font-size: 20px; color: #a855f7; display:flex; align-items:center; justify-content:center; width:36px; height:36px; background:#f3e8ff; border-radius:8px; }
.rs-label { font-size: 13px; color: #4b5563; font-weight: 600; }
.rs-val { font-size: 15px; font-weight: 800; color: #111827; }

/* Progress Bars */
.pb-item {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
    font-size: 13px;
}
.pb-label { width: 110px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; }
.pb-bar-bg {
    flex: 1;
    height: 8px;
    background: #f1f5f9;
    border-radius: 4px;
    margin: 0 16px;
    position: relative;
}
.pb-bar-fill {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    border-radius: 4px;
}
.pb-pct { width: 45px; text-align: right; font-weight: 700; color: #3b82f6; font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; }

/* New Arrival Table */
.c-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.c-table th { text-align: left; padding: 8px 0; color: #6b7280; font-weight: 500; border-bottom: 1px solid #e5e7eb; }
.c-table td { padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #111827; }
.c-table tr:last-child td { border-bottom: none; }
.td-name { display: flex; align-items: center; gap: 8px; font-weight: 500; }
.td-avatar { width: 24px; height: 24px; border-radius: 50%; background: #e5e7eb; }
.td-time { color: #9ca3af; }

/* ── RIGHT SIDEBAR ── */
.c-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.cal-tabs {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 16px;
}
.cal-tab {
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
}
.cal-tab.active {
    color: #111827;
    border-bottom: 2px solid #111827;
}

.cal-list { display: flex; flex-direction: column; }
.cal-item {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}
.cal-date {
    width: 40px;
    text-align: center;
    border-right: 1px solid #e5e7eb;
    padding-right: 12px;
    margin-right: 12px;
}
.cd-num { font-size: 16px; font-weight: 700; color: #111827; }
.cd-day { font-size: 11px; color: #9ca3af; }
.cal-content { flex: 1; }
.cc-title { font-size: 13px; font-weight: 600; color: #111827; margin-bottom: 4px; }
.cc-avatars { display: flex; }
.cc-avatar { width: 20px; height: 20px; border-radius: 50%; background: #e5e7eb; border: 2px solid #fff; margin-left: -6px; }
.cc-avatar:first-child { margin-left: 0; }
.cal-more { color: #9ca3af; cursor: pointer; }
.cal-available { font-size: 13px; color: #3b82f6; display: flex; align-items: center; gap: 4px; padding-top: 6px;}

.task-item {
    padding: 16px;
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    margin-bottom: 12px;
}
.task-date { font-size: 11px; color: #9ca3af; margin-bottom: 4px; }
.task-title { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.4; }

/* Custom Doughnut Legend */
.dl-box {
    margin-bottom: 16px;
    font-size: 12px;
}
.dl-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    color: #4b5563;
}
.dl-dot { width: 8px; height: 8px; border-radius: 50%; }
</style>
@endpush

@section('content')

@php
    $totalOrders = $stats['total_order'] ?? 0;
    $orderWait = $stats['order_menunggu'] ?? 0;
    $orderDone = $stats['order_selesai'] ?? 0;
    $totalRev = $stats['total_revenue'] ?? 0;
@endphp

<div class="complex-db">
    
    {{-- MAIN AREA --}}
    <div class="c-main">
        
        {{-- TOP CARDS --}}
        <div class="c-stats-grid">
            <div class="c-stat-box">
                <div class="cs-header">
                    <span>Pesanan Baru</span>
                    <i class="bi bi-cart cs-icon"></i>
                </div>
                <div class="cs-value">{{ number_format($totalOrders, 0, ',', '.') }}</div>
                <div class="cs-footer">
                    <span class="cs-badge blue" style="background:#f1f5f9; color:#475569;"><i class="bi bi-calendar-day"></i> Hari Ini</span>
                    <span class="cs-sub">Total hari ini</span>
                </div>
            </div>
            <div class="c-stat-box">
                <div class="cs-header">
                    <span>Menunggu</span>
                    <i class="bi bi-hourglass-split cs-icon" style="color: #a855f7;"></i>
                </div>
                <div class="cs-value">{{ number_format($orderWait, 0, ',', '.') }}</div>
                <div class="cs-footer">
                    <span class="cs-badge purple" style="background:#f3e8ff; color:#7e22ce;"><i class="bi bi-arrow-repeat"></i> Proses</span>
                    <span class="cs-sub">Perlu diproses</span>
                </div>
            </div>
            <div class="c-stat-box">
                <div class="cs-header">
                    <span>Pesanan Selesai</span>
                    <i class="bi bi-check-circle cs-icon" style="color: #ef4444;"></i>
                </div>
                <div class="cs-value">{{ number_format($orderDone, 0, ',', '.') }}</div>
                <div class="cs-footer">
                    <span class="cs-badge red" style="background:#fef2f2; color:#dc2626;"><i class="bi bi-check2-all"></i> Selesai</span>
                    <span class="cs-sub">Total Riwayat</span>
                </div>
            </div>
            <div class="c-stat-box">
                <div class="cs-header">
                    <span>Pendapatan</span>
                    <i class="bi bi-wallet2 cs-icon" style="color: #3b82f6;"></i>
                </div>
                <div class="cs-value">Rp {{ number_format($totalRev, 0, ',', '.') }}</div>
                <div class="cs-footer">
                    <span class="cs-badge blue" style="background:#eff6ff; color:#1d4ed8;"><i class="bi bi-cash-stack"></i> Total</span>
                    <span class="cs-sub">Seluruh Pendapatan</span>
                </div>
            </div>
        </div>

        {{-- MIDDLE ROW --}}
        <div class="c-middle-row">
            {{-- Occupancy Chart --}}
            <div class="c-card">
                <div class="c-title-row">
                    <h3 class="c-title">Tren Pesanan</h3>
                    <div style="display:flex; gap:8px;">
                        <button class="c-btn-dropdown">Sepanjang Waktu</button>
                    </div>
                </div>
                <div style="height: 250px;">
                    <canvas id="occupancyChart"></canvas>
                </div>
            </div>

            {{-- Booking by platform --}}
            <div class="c-card">
                <div class="c-title-row">
                    <h3 class="c-title">Kategori Layanan</h3>
                    <i class="bi bi-three-dots"></i>
                </div>
                
                <div class="dl-box" id="platformLegend">
                    {{-- Injected JS --}}
                </div>

                <div style="height: 180px; position:relative; display:flex; justify-content:center;">
                    <canvas id="platformChart"></canvas>
                </div>
            </div>
        </div>

        {{-- BOTTOM ROW --}}
        <div class="c-bottom-row">
            {{-- Revenue Overview --}}
            <div class="c-card">
                <h3 class="c-title" style="margin-bottom:16px;">Ringkasan Pendapatan</h3>
                
                <div class="rev-total-box">
                    <div class="rev-label">Total pendapatan</div>
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="rev-val" style="font-size:26px; font-weight:800; color:#111827; word-break:break-all;">Rp {{ number_format($totalRev, 0, ',', '.') }}</div>
                        <button class="c-btn-dropdown">Sepanjang Waktu</button>
                    </div>
                </div>

                <div class="rev-split">
                    <div class="rev-split-item">
                        <div class="rs-left">
                            <i class="bi bi-wallet2 rs-icon"></i>
                            <div class="rs-label">Pesanan Tunai</div>
                        </div>
                        <div class="rs-val">Rp {{ number_format($totalRev * 0.4, 0, ',', '.') }}</div>
                    </div>
                    <div class="rev-split-item">
                        <div class="rs-left">
                            <i class="bi bi-bank rs-icon"></i>
                            <div class="rs-label">Transfer Bank</div>
                        </div>
                        <div class="rs-val">Rp {{ number_format($totalRev * 0.6, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div id="topPartnersBars">
                    {{-- Diisi dengan bar PHP/HTML --}}
                    @php
                        $colors = ['#3b82f6', '#8b5cf6', '#d8b4fe', '#ef4444'];
                        $maxRev = isset($topPartners[0]) ? $topPartners[0]['total_revenue'] : 1;
                        if ($maxRev <= 0) $maxRev = 1;
                    @endphp
                    @foreach($topPartners as $index => $partner)
                        @php
                            $pct = ($partner['total_revenue'] / $maxRev) * 100;
                            $col = $colors[$index % count($colors)];
                        @endphp
                        <div class="pb-item">
                            <div class="pb-label" title="{{ $partner['nama'] }}">{{ $partner['nama'] }}</div>
                            <div class="pb-bar-bg">
                                <div class="pb-bar-fill" style="width: {{ $pct }}%; background: {{ $col }};"></div>
                            </div>
                            <div class="pb-pct">{{ round($pct) }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Reservation & New Arrival --}}
            <div class="c-card" style="display:flex; flex-direction:column; gap:24px;">
                
                {{-- Bar Chart --}}
                <div>
                    <div class="c-title-row">
                        <h3 class="c-title">Riwayat Pesanan</h3>
                        <button class="c-btn-dropdown">7 Hari Terakhir <i class="bi bi-chevron-down"></i></button>
                    </div>
                    <div style="height: 180px;">
                        <canvas id="reservationChart"></canvas>
                    </div>
                </div>

                {{-- Table --}}
                <div>
                    <div class="c-title-row" style="margin-bottom:8px;">
                        <h3 class="c-title">Pesanan Terbaru</h3>
                        <a href="{{ route('orders.index') }}" style="font-size:13px; font-weight:600; color:#3b82f6; text-decoration:none;">Lihat semua</a>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="c-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $ro)
                                <tr>
                                    <td style="font-weight:600; color:#6b7280;">#{{ $ro['id_order'] }}</td>
                                    <td>
                                        <div class="td-name">
                                            <div class="td-avatar"><img src="https://ui-avatars.com/api/?name={{ urlencode($ro['nama_pelanggan']) }}&background=e0e7ff&color=3730a3" style="width:100%; border-radius:50%;"></div>
                                            {{ $ro['nama_pelanggan'] }}
                                        </div>
                                    </td>
                                    <td class="td-time">{{ \Carbon\Carbon::parse($ro['tgl_kunjungan'])->locale('id')->diffForHumans() }}</td>
                                    <td><a href="{{ route('orders.index') }}" style="color:#9ca3af;"><i class="bi bi-arrow-right-circle-fill" style="font-size:18px;"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="c-sidebar">
        
        {{-- Calendar Card --}}
        <div class="c-card" style="padding:0;">
            <div style="padding:20px;">
                <div class="cal-header">
                    <h3 class="c-title"><i class="bi bi-calendar-event"></i> Jadwal Kunjungan</h3>
                    <button class="c-btn-dropdown">Bulan Ini <i class="bi bi-chevron-down"></i></button>
                </div>
                {{-- Dihapus: cal-tabs karena tidak relevan dengan booking Servizz --}}

                <div class="cal-list" style="margin-top: 10px;">
                    @forelse($calendarBookings as $bk)
                    <div class="cal-item">
                        <div class="cal-date">
                            <div class="cd-num">{{ \Carbon\Carbon::parse($bk['tgl_kunjungan'])->format('d') }}</div>
                            <div class="cd-day">{{ \Carbon\Carbon::parse($bk['tgl_kunjungan'])->locale('id')->format('D') }}</div>
                        </div>
                        <div class="cal-content">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div>
                                    <div class="cc-title" style="text-transform: capitalize;">{{ $bk['nama_service'] }}</div>
                                    <div class="cc-avatars" style="display:flex; align-items:center; gap:6px; margin-top:6px;">
                                        <div class="cc-avatar" style="margin-left:0; border:none;"><img src="https://ui-avatars.com/api/?name={{ urlencode($bk['nama_pelanggan']) }}&background=e0e7ff&color=3730a3" style="width:100%; border-radius:50%;"></div>
                                        <div style="font-size:11.5px; color:#6b7280; font-weight:500;">{{ $bk['nama_pelanggan'] }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('orders.index') }}" class="cal-more" title="Lihat detail"><i class="bi bi-arrow-right-short" style="font-size:18px;"></i></a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="cal-item">
                        <div class="cal-content">
                            <div class="cal-available"><i class="bi bi-plus-circle"></i> Available</div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Task Card --}}
        <div class="c-card">
            <div class="c-title-row" style="margin-bottom: 16px;">
                <h3 class="c-title"><i class="bi bi-ui-checks"></i> Tugas Verifikasi</h3>
                <a href="{{ route('technicians.index') }}" style="font-size:13px; font-weight:600; color:#3b82f6; text-decoration:none;">Lihat semua</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($pendingTasks as $pt)
                <div class="task-item" style="margin-bottom:0; display:flex; justify-content:space-between; align-items:center; transition: all 0.2s ease;">
                    <div>
                        <div class="task-date" style="display:flex; align-items:center; gap:4px;"><i class="bi bi-clock-history"></i> {{ \Carbon\Carbon::parse($pt['created_at'])->locale('id')->diffForHumans() }}</div>
                        <div class="task-title">Mitra Baru: <span style="color:#3b82f6;">{{ $pt['nama'] }}</span></div>
                    </div>
                    <a href="{{ route('technicians.index') }}" style="background:#eff6ff; color:#3b82f6; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none; border: 1px solid #bfdbfe;">Tinjau</a>
                </div>
                @empty
                <div style="text-align:center; padding: 32px 16px; background: #f9fafb; border-radius: 8px; border: 1px dashed #e5e7eb;">
                    <i class="bi bi-check-circle-fill" style="font-size:36px; color:#10b981; margin-bottom:12px; display:inline-block;"></i>
                    <div style="font-size:14px; font-weight:700; color:#111827;">Semua beres!</div>
                    <div style="font-size:12px; color:#6b7280; margin-top:6px;">Tidak ada mitra yang menunggu verifikasi.</div>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($charts ?? []);
    
    // Config global Chart.js
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.plugins.tooltip.backgroundColor = '#111827';
    Chart.defaults.plugins.tooltip.padding = 10;
    Chart.defaults.plugins.tooltip.cornerRadius = 6;

    // 1. OCCUPANCY CHART (Line with Area)
    const occCtx = document.getElementById('occupancyChart').getContext('2d');
    
    // Create gradient
    let gradientFill = occCtx.createLinearGradient(0, 0, 0, 250);
    gradientFill.addColorStop(0, 'rgba(168, 85, 247, 0.4)'); // purple-500
    gradientFill.addColorStop(1, 'rgba(255, 255, 255, 0)');

    let oLabels = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
    let oData = [18, 18, 65, 65, 82, 82, 75]; // Mock data to match shape
    
    if (chartData.orderTrends && chartData.orderTrends.length > 0) {
        oData = [];
        oLabels = [];
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        chartData.orderTrends.forEach(r => {
            let mName = r.month >= 1 && r.month <= 12 ? monthNames[r.month - 1] : 'M' + r.month;
            oLabels.push(mName);
            oData.push(r.total_pesanan); // data asli tanpa dikali
        });
    }

    new Chart(occCtx, {
        type: 'line',
        data: {
            labels: oLabels,
            datasets: [{
                label: 'Pesanan',
                data: oData,
                borderColor: '#a855f7',
                backgroundColor: gradientFill,
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#a855f7',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.1 // Slight curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6', drawBorder: false },
                    border: { display: false },
                    ticks: { precision: 0 }
                },
                x: {
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });

    // 2. PLATFORM CHART (Doughnut)
    const platCtx = document.getElementById('platformChart').getContext('2d');
    let pLabels = ['direct booking', 'Booking.red.com', 'Social media', 'Air BnB', 'others'];
    let pData = [61, 13, 6, 11, 3];
    let pColors = ['#d8b4fe', '#93c5fd', '#bfdbfe', '#60a5fa', '#fca5a5'];

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
                cutout: '65%',
                borderRadius: 20,
                spacing: 4
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
        let color = pColors[i % pColors.length];
        let val = Number(pData[i]);
        let pct = totalPData > 0 ? Math.round((val / totalPData) * 100) : 0;
        legendHtml += `
            <div class="dl-item">
                <div class="dl-dot" style="background:${color}"></div>
                <div style="font-weight:600; color:#111827; width:40px;">${pct}%</div>
                <div style="text-transform: capitalize;">${l}</div>
            </div>
        `;
    });
    document.getElementById('platformLegend').innerHTML = legendHtml;

    // 3. RESERVATION CHART (Bar standard)
    const resCtx = document.getElementById('reservationChart').getContext('2d');
    let rLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    let rData = [2, 5, 3, 6, 4, 8, 5];
    
    new Chart(resCtx, {
        type: 'bar',
        data: {
            labels: rLabels,
            datasets: [
                {
                    label: 'Pesanan Selesai',
                    data: rData,
                    backgroundColor: '#d8b4fe',
                    borderRadius: 6,
                    barPercentage: 0.4,
                    categoryPercentage: 0.6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6', drawBorder: false },
                    border: { display: false },
                    ticks: { precision: 0, stepSize: 2 }
                },
                x: {
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
});
</script>
@endsection
