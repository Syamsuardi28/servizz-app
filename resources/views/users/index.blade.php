{{-- Lokasi: resources/views/users/index.blade.php --}}
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

<div class="upage-wrap">

    {{-- ── Top Stat Cards ── --}}
    <div class="upage-top-cards" style="margin-bottom: 24px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        {{-- Card 1: Pelanggan --}}
        <div class="ustat-card">
            <div class="ustat-card-head">
                <div class="ustat-icon-wrap" style="color: #db2777; background: #fdf2f8;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="ustat-label-wrap">
                    <span class="ustat-title">Pelanggan</span>
                    <span class="ustat-sub">Terdaftar</span>
                </div>
            </div>
            <div class="ustat-value-row">
                <span class="ustat-val">{{ $totalPelanggan }}</span>
                <div class="ustat-indicator-line" style="background: #db2777"></div>
            </div>
        </div>

        {{-- Card 2: Mitra --}}
        <div class="ustat-card">
            <div class="ustat-card-head">
                <div class="ustat-icon-wrap" style="color: #7c3aed; background: #f5f3ff;">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <div class="ustat-label-wrap">
                    <span class="ustat-title">Mitra / Teknisi</span>
                    <span class="ustat-sub">Mitra Terdaftar</span>
                </div>
            </div>
            <div class="ustat-value-row">
                <span class="ustat-val">{{ $totalMitra }}</span>
                <div class="ustat-indicator-line" style="background: #7c3aed"></div>
            </div>
        </div>

        {{-- Card 3: Gradient Total --}}
        <div class="ustat-card-gradient">
            <div class="ugrad-bg-pattern"></div>
            <div class="ugrad-content">
                <div class="ugrad-left">
                    <div class="ugrad-val">{{ $totalActive }}</div>
                    <div class="ugrad-lbl">Pengguna Aktif</div>
                </div>
                <div class="ugrad-right">
                    <div class="ugrad-circle">
                        <span>{{ $activePercent }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Middle Header Row (Search & Refresh) ── --}}
    <div class="upage-mid-bar" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div class="upage-tabs-bar" style="display: flex; gap: 8px;">
            <a href="{{ route('users.index') }}" class="utab-link {{ !$role ? 'active' : '' }}">
                Semua
            </a>
            <a href="{{ route('users.index', ['role' => 'Pelanggan']) }}" class="utab-link {{ $role === 'Pelanggan' ? 'active' : '' }}">
                Pelanggan
            </a>
            <a href="{{ route('users.index', ['role' => 'Mitra']) }}" class="utab-link {{ $role === 'Mitra' ? 'active' : '' }}">
                Mitra
            </a>
        </div>
        <div class="upage-actions-wrap" style="display: flex; gap: 12px; flex: 1; max-width: 400px;">
            <div class="upage-search-box" style="flex: 1; position: relative;">
                <i class="bi bi-search search-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" id="userSearch" class="upage-search-input" placeholder="Cari pengguna..." style="width: 100%; padding: 10px 16px 10px 44px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
            </div>
            <a href="{{ route('users.index') }}" class="upage-refresh-btn" style="background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 8px; color: #475569; text-decoration: none; font-weight: 600;">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </div>

    {{-- ── Card Grid ── --}}
    <div class="ats-user-grid">
        @forelse($users as $u)
            @php
                $initial = strtoupper(substr($u['nama'] ?? 'U', 0, 1));
                
                $noHp = $u['no_hp'] ?? '';
                $waLink = $noHp ? 'https://wa.me/' . preg_replace('/^0/', '62', $noHp) : '#';
            @endphp
            <div class="ats-u-card">
                <a href="{{ route('users.show', $u['id_user']) }}" style="text-decoration:none; display:flex; flex-direction:column; align-items:center; width:100%;">
                    <div class="ats-u-avatar-wrap">
                        <div class="ats-u-avatar" style="background: {{ $u['role'] === 'Pelanggan' ? 'linear-gradient(135deg, #0ea5e9, #2563eb)' : 'linear-gradient(135deg, #f59e0b, #ea580c)' }}">
                            {{ $initial }}
                        </div>
                    </div>
                    
                    <h3 class="ats-u-name">{{ $u['nama'] }}</h3>
                    <p class="ats-u-role">{{ $u['role'] }}</p>
                </a>

                {{-- Action Circles --}}
                <div class="ats-u-circles">
                    <div class="ats-u-circle" title="{{ $u['email'] }}">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="ats-u-circle" title="{{ $u['no_hp'] ?? 'Tidak ada nomor' }}">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div class="ats-u-circle" title="Bergabung pada {{ \Carbon\Carbon::parse($u['created_at'])->format('d M Y') }}">
                        <i class="bi bi-calendar"></i>
                    </div>
                    <div class="ats-u-circle" title="{{ $u['is_active'] ? 'Akun Aktif' : 'Akun Nonaktif' }}" style="color: {{ $u['is_active'] ? '#10b981' : '#ef4444' }}; border-color: {{ $u['is_active'] ? '#a7f3d0' : '#fecaca' }}">
                        <i class="bi bi-toggle-{{ $u['is_active'] ? 'on' : 'off' }}"></i>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="ats-u-buttons">
                    <a href="{{ $waLink }}" target="{{ $noHp ? '_blank' : '_self' }}" class="ats-u-btn ats-btn-msg" onclick="{{ !$noHp ? 'alert(\'Nomor HP tidak tersedia\'); return false;' : '' }}">
                        hubungi
                    </a>
                    
                    <form method="POST" action="{{ route('users.toggle', $u['id_user']) }}" onsubmit="confirmToggle(event, this, '{{ $u['is_active'] ? 'menonaktifkan' : 'mengaktifkan' }}', '{{ addslashes($u['nama']) }}')" style="margin:0; flex:1; display:flex;">
                        @csrf
                        <button type="submit" class="ats-u-btn ats-btn-status">
                            {{ $u['is_active'] ? 'nonaktifkan' : 'aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1; color: #64748b;">
                <i class="bi bi-people" style="font-size: 32px; color: #94a3b8; margin-bottom: 12px; display: block;"></i>
                <p>Tidak ada pengguna ditemukan.</p>
            </div>
        @endforelse
    </div>

</div>

<link rel="stylesheet" href="{{ asset('css/users.css') }}">
<style>
/* Reset base styles to adapt new layout */
.upage-wrap {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}
.utab-link {
    text-decoration: none;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    border-radius: 8px;
    transition: all 0.2s;
}
.utab-link.active {
    background: #e0e7ff;
    color: #4f46e5;
}

/* ── Top Stat Cards ── */
.ustat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 120px;
}
.ustat-card-head {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ustat-icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.ustat-label-wrap {
    display: flex;
    flex-direction: column;
}
.ustat-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.ustat-sub {
    font-size: 13px;
    color: #64748b;
}
.ustat-value-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 16px;
}
.ustat-val {
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}
.ustat-indicator-line {
    width: 4px;
    height: 24px;
    border-radius: 4px;
}

/* Gradient Card */
.ustat-card-gradient {
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    border-radius: 16px;
    padding: 24px;
    color: #fff;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 120px;
}
.ugrad-bg-pattern {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: radial-gradient(rgba(255,255,255,0.2) 2px, transparent 2px);
    background-size: 14px 14px;
    opacity: 0.5;
}
.ugrad-content {
    position: relative;
    z-index: 1;
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
.ugrad-left {
    display: flex;
    flex-direction: column;
}
.ugrad-val {
    font-size: 36px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}
.ugrad-lbl {
    font-size: 14px;
    font-weight: 500;
    opacity: 0.9;
}
.ugrad-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    background: rgba(255,255,255,0.1);
}

/* ── Card Grid ── */
.ats-user-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 24px;
    width: 100%;
}

/* ── User Card ── */
.ats-u-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    padding: 32px 24px 24px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid transparent;
}
.ats-u-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    border-color: #e2e8f0;
}

/* Avatar */
.ats-u-avatar-wrap {
    margin-bottom: 16px;
}
.ats-u-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
    color: #ffffff;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

/* Text */
.ats-u-name {
    font-size: 16px;
    font-weight: 700;
    color: #06b6d4; /* Cyan as requested */
    margin: 0 0 4px 0;
    text-align: center;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ats-u-role {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
    margin: 0 0 20px 0;
    text-transform: capitalize;
}

/* Icons */
.ats-u-circles {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
}
.ats-u-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.2s;
}
.ats-u-circle:hover {
    background: #f1f5f9;
    color: #475569;
}

/* Buttons */
.ats-u-buttons {
    display: flex;
    gap: 12px;
    width: 100%;
}
.ats-u-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: #ffffff;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: filter 0.2s;
    font-family: inherit;
}
.ats-u-btn:hover {
    filter: brightness(0.9);
}
.ats-btn-msg {
    background: #22c55e; /* Green */
}
.ats-btn-status {
    background: #0ea5e9; /* Light Blue / Cyan */
}
</style>

<script>
// SweetAlert Confirm
function confirmToggle(event, formElement, actionName, userName) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin ${actionName} akun ${userName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0ea5e9',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal',
        background: '#ffffff',
        borderRadius: '12px'
    }).then((result) => {
        if (result.isConfirmed) {
            formElement.submit();
        }
    });
}

// Search user functionality (Adapted for Grid)
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
