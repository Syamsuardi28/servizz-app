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

@push('styles')
    @vite('resources/css/users.css')
@endpush
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
