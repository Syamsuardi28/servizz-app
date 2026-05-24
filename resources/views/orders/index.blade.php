{{-- Lokasi: resources/views/orders/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Kelola Pesanan')
@section('breadcrumb', 'Pesanan')

@section('content')
@php
$badgeMap = [
    'Menunggu'          => 'yellow',
    'Dikonfirmasi'      => 'blue',
    'Teknisi Berangkat' => 'indigo',
    'Sedang Dikerjakan' => 'purple',
    'Selesai'           => 'green',
    'Dibatalkan'        => 'red',
];
@endphp

@push('styles')
    @vite('resources/css/orders.css')
@endpush

<div class="ord-wrap">

    {{-- ── Header ── --}}
    <div class="ord-header-bar">
        <div class="ord-tabs">
            <a href="#" class="ord-tab active"><i class="bi bi-list-task"></i> List</a>
        </div>
        
        <div class="ord-filters">
            <div class="ord-filter-select" style="position:relative; padding-right: 24px;">
                <span>Show:</span> 
                <select id="statusFilter" onchange="updateFilters()" style="background:transparent; border:none; font-weight:700; color:#1e293b; outline:none; cursor:pointer; appearance:none; margin-left:4px;">
                    <option value="">All Projects</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ $filterStatus === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down" style="position:absolute; right:10px; pointer-events:none; font-size:12px; color:#1e293b; font-weight:bold;"></i>
            </div>
            @if(session('servizz_user.role') === 'Pelanggan')
                <a href="{{ route('services.index') }}" class="ord-btn-add">
                    <i class="bi bi-plus-lg"></i> Add Project
                </a>
            @else
                <a href="{{ route('orders.index') }}" class="ord-btn-add">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </a>
            @endif
        </div>
    </div>

    {{-- ── List Header ── --}}
    <div class="ord-list-header">
        <div><input type="checkbox" class="ord-checkbox" disabled></div>
        <div>PROJECT NAME</div>
        <div>START DATE</div>
        <div>DEADLINE</div>
        <div>CURRENCY</div>
        <div>STATUS</div>
        <div>PEOPLE</div>
        <div style="text-align: right;"><i class="bi bi-plus-lg"></i></div>
    </div>

    {{-- ── List Items ── --}}
    <div>
        @forelse($orders as $index => $o)
            @php
                // Map color badges dynamically
                $st = $o['status_order'];
                $badgeClass = 'gray';
                $prio = 'low';
                if ($st === 'Selesai') { $badgeClass = 'green'; $prio = 'low'; }
                elseif ($st === 'Menunggu') { $badgeClass = 'orange'; $prio = 'high'; }
                elseif ($st === 'Dikonfirmasi') { $badgeClass = 'blue'; $prio = 'medium'; }
                elseif ($st === 'Teknisi Berangkat') { $badgeClass = 'purple'; $prio = 'medium'; }
                elseif ($st === 'Sedang Dikerjakan') { $badgeClass = 'teal'; $prio = 'low'; }
                elseif ($st === 'Dibatalkan') { $badgeClass = 'red'; $prio = 'high'; }

                // Prio label
                $prioLabel = ucfirst($prio);

                // Icon Background based on index
                $iconColors = ['#3b82f6', '#ef4444', '#0ea5e9', '#a855f7', '#f59e0b', '#10b981'];
                $bg = $iconColors[$index % count($iconColors)];
                
                // Get initials
                $svcInitial = strtoupper(substr($o['nama_service'], 0, 1));
            @endphp
        <div class="ord-list-item">
            
            <div><input type="checkbox" class="ord-checkbox"></div>

            <div class="ord-col-project">
                <div class="ord-icon-box" style="background-color: {{ $bg }}">
                    <i class="bi bi-boxes"></i>
                </div>
                <div class="ord-project-text">
                    <span class="ord-project-title">{{ Str::limit($o['nama_service'], 25) }}</span>
                    <span class="ord-project-sub">{{ Str::limit($o['nama_pelanggan'] ?? 'Pelanggan', 20) }}</span>
                </div>
            </div>

            <div class="ord-col-text">
                {{ \Carbon\Carbon::parse($o['tgl_kunjungan'])->format('d/m/Y') }}
            </div>

            <div class="ord-col-text">
                {{ \Carbon\Carbon::parse($o['waktu_kunjungan'] ?? $o['tgl_kunjungan'])->format('H:i') }}
            </div>

            <div class="ord-col-currency">
                Rp{{ number_format($o['biaya_kunjungan'], 0, ',', '.') }}
            </div>

            <div>
                <span class="ord-badge ord-badge-{{ $badgeClass }}">
                    {{ $st }}
                </span>
            </div>

            <div class="ord-avatars">
                @if($o['nama_mitra'] ?? null)
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($o['nama_mitra']) }}&background=random" class="ord-avatar" alt="Mitra">
                @endif
                <img src="https://ui-avatars.com/api/?name={{ urlencode($o['nama_pelanggan'] ?? 'Pelanggan') }}&background=random" class="ord-avatar" alt="Pelanggan">
            </div>
            

            <div>
                <a href="{{ route('orders.show', $o['id_order']) }}" class="ord-action-btn" title="Detail">
                    <i class="bi bi-three-dots-vertical"></i>
                </a>
            </div>

        </div>
        @empty
        <div class="ord-empty">
            <i class="bi bi-inbox"></i>
            <p>Tidak ada pesanan{{ $filterStatus ? ' dengan status '.$filterStatus : '' }}.</p>
        </div>
        @endforelse
    </div>

</div>

@section('scripts')
<script>
function updateFilters() {
    const status = document.getElementById('statusFilter').value;
    let url = '{{ route("orders.index") }}?';
    if(status) url += 'status=' + encodeURIComponent(status);
    window.location.href = url;
}
</script>
@endsection

@endsection
