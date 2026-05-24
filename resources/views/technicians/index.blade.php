{{-- Lokasi: resources/views/technicians/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Mitra / Teknisi')
@section('breadcrumb', 'Mitra / Teknisi')

@push('styles')
    @vite('resources/css/technicians.css')
@endpush

@section('content')
@php
    $statusMap = [
        'Terverifikasi' => ['label'=>'Terverifikasi','color'=>'#10b981'],
        'Pending'       => ['label'=>'Pending',      'color'=>'#f59e0b'],
        'Ditolak'       => ['label'=>'Ditolak',      'color'=>'#ef4444'],
    ];
@endphp

<div style="padding: 10px 0;">

    {{-- ── Top Navigation Tabs (Filters) ── --}}
    <div class="ats-nav-tabs">
        <a href="{{ route('technicians.index') }}" class="ats-nav-tab {{ !$filter ? 'active' : '' }}">
            Semua Teknisi
        </a>
        @foreach(['Pending', 'Terverifikasi', 'Ditolak'] as $s)
        <a href="{{ route('technicians.index', ['status' => $s]) }}" class="ats-nav-tab {{ $filter === $s ? 'active' : '' }}">
            {{ $s }}
        </a>
        @endforeach
    </div>

    {{-- ── Top Actions (Dashboard Stats) ── --}}
    <div class="ats-top-actions">
        @php
            $allTechs       = is_array($techs) ? $techs : [];
            $totalVerif     = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Terverifikasi'));
            $totalPending   = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Pending'));
            $totalDitolak   = count(array_filter($allTechs, fn($t) => ($t['status_verifikasi'] ?? '') === 'Ditolak'));
        @endphp
        <div style="display: flex; gap: 20px; align-items: center; width: 100%; justify-content: space-between;">
            <div style="display: flex; gap: 24px;">
                <span style="font-size: 14px; color: #64748b;">Terverifikasi: <strong style="color: #1e293b;">{{ $totalVerif }}</strong></span>
                <span style="font-size: 14px; color: #64748b;">Pending: <strong style="color: #1e293b;">{{ $totalPending }}</strong></span>
                <span style="font-size: 14px; color: #64748b;">Ditolak: <strong style="color: #1e293b;">{{ $totalDitolak }}</strong></span>
            </div>
            
            <div class="ats-search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Zoeken (Cari)...">
            </div>
        </div>
    </div>

    {{-- ── Grid Layout ── --}}
    <div class="ats-tech-grid">
        @if(is_array($techs) && count($techs) > 0)
            @foreach($techs as $t)
                @php
                    $st       = $t['status_verifikasi'] ?? 'Pending';
                    $sinfo    = $statusMap[$st] ?? $statusMap['Pending'];
                    $initials = strtoupper(substr($t['nama'] ?? 'T', 0, 1));
                    
                    // Assign random ring color based on ID
                    $ringColors = ['ats-ring-cyan', 'ats-ring-orange', 'ats-ring-emerald', 'ats-ring-purple'];
                    $ringClass  = $ringColors[crc32($t['id_tech'] ?? 'x') % count($ringColors)];
                    
                    // Assign random solid background for avatar inside
                    $bgColors = ['#4e488d','#2563eb','#059669','#d97706','#7c3aed','#0891b2'];
                    $avatarBg = $bgColors[crc32($t['nama'] ?? 'y') % count($bgColors)];
                @endphp
                <div class="ats-tech-card">
                    
                    {{-- Edit Dropdown (Top Right) --}}
                    @if(session('servizz_user.role') === 'Admin')
                        <a href="#" class="ats-card-action" onclick="var d=document.getElementById('dropdown-{{ $t['id_tech'] }}'); d.style.display=d.style.display==='block'?'none':'block'; return false;">
                            <i class="bi bi-pencil-fill" style="font-size: 10px;"></i>
                            <i class="bi bi-chevron-down" style="font-size: 10px; margin-left:2px;"></i>
                        </a>
                        <div id="dropdown-{{ $t['id_tech'] }}" class="ats-card-dropdown">
                            <form method="POST" action="{{ route('technicians.verify', $t['id_tech']) }}">
                                @csrf
                                <select name="status">
                                    <option value="Terverifikasi" {{ $st==='Terverifikasi'?'selected':'' }}>Terverifikasi</option>
                                    <option value="Pending" {{ $st==='Pending'?'selected':'' }}>Pending</option>
                                    <option value="Ditolak" {{ $st==='Ditolak'?'selected':'' }}>Ditolak</option>
                                </select>
                                <button type="submit">Ubah Status</button>
                            </form>
                        </div>
                    @endif

                    {{-- Avatar --}}
                    <div class="ats-avatar-wrapper {{ $ringClass }}">
                        <div class="ats-avatar-inner" style="background: {{ $avatarBg }};">
                            {{ $initials }}
                        </div>
                    </div>

                    {{-- Info --}}
                    <h3 class="ats-tech-name">{{ $t['nama'] ?? '—' }}</h3>
                    <div class="ats-tech-status" style="color: {{ $sinfo['color'] }}">
                        {{ $sinfo['label'] }}
                    </div>

                    {{-- Metrik --}}
                    <div class="ats-stat-row">
                        <span class="ats-stat-label">KEAHLIAN</span>
                        <span class="ats-stat-value">{{ $t['keahlian'] ?? 'Umum' }}</span>
                    </div>
                    <div class="ats-stat-row">
                        <span class="ats-stat-label">RATING</span>
                        <span class="ats-stat-value">⭐ {{ number_format($t['rating_rata2'] ?? 0, 1) }}</span>
                    </div>

                    {{-- Bottom Action Button --}}
                    @if($st === 'Pending' && session('servizz_user.role') === 'Admin')
                        <form method="POST" action="{{ route('technicians.verify', $t['id_tech']) }}" style="margin-top: auto; display:block; width:100%;">
                            @csrf
                            <input type="hidden" name="status" value="Terverifikasi">
                            <button type="submit" class="ats-action-btn ats-action-btn-primary">
                                Verifikasi Sekarang
                            </button>
                        </form>
                    @else
                        <a href="{{ route('technicians.show', $t['id_tech']) }}" class="ats-action-btn">
                            Lihat Detail
                        </a>
                    @endif

                </div>
            @endforeach
        @else
            <div class="ats-empty">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada teknisi ditemukan.</p>
            </div>
        @endif
    </div>

</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                const cards = document.querySelectorAll('.ats-tech-card');
                
                cards.forEach(card => {
                    const name = card.querySelector('.ats-tech-name').innerText.toLowerCase();
                    const skill = card.querySelector('.ats-stat-value').innerText.toLowerCase();
                    if (name.includes(term) || skill.includes(term)) {
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
@endsection
