@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('breadcrumb', 'Pengguna / Detail')

@section('content')

<div class="ats-profile-wrap">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('users.index') }}" style="display:inline-flex; align-items:center; gap:8px; text-decoration:none; color:#64748b; font-weight:600; font-size:14px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pengguna
        </a>
    </div>

    {{-- Top Section: Avatar & Bio --}}
    <div class="ats-hero-section">
        <div class="ats-avatar-container">
            @if(!empty($user['foto_profil']))
                <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ $user['foto_profil'] }}" alt="Avatar">
            @else
                <div class="ats-avatar-placeholder">
                    {{ strtoupper(substr($user['nama'] ?? 'U', 0, 1)) }}
                </div>
            @endif
        </div>
        
        <div class="ats-bio-container">
            <span class="ats-bio-role">{{ $user['role'] ?? 'Pengguna' }}</span>
            <h1 class="ats-bio-name">{{ $user['nama'] ?? 'Pengguna Servizz' }}</h1>
            <p class="ats-bio-desc">
                Ini adalah halaman detail untuk pengguna <strong>{{ $user['nama'] }}</strong>. Di sini Anda dapat meninjau informasi kontak yang terdaftar serta aktivitas pesanan yang melibatkan pengguna ini di dalam sistem Servizz.
            </p>
            <div class="ats-bio-buttons">
                @php 
                    $noHp = $user['no_hp'] ?? '';
                    $waLink = $noHp ? 'https://wa.me/' . preg_replace('/^0/', '62', $noHp) : '#';
                @endphp
                <a href="{{ $waLink }}" target="{{ $noHp ? '_blank' : '_self' }}" onclick="{{ !$noHp ? 'alert(\'Nomor HP tidak tersedia\'); return false;' : '' }}" class="ats-btn ats-btn-primary">Hubungi Pengguna</a>
                
                <form method="POST" action="{{ route('users.toggle', $user['id_user']) }}" style="display:inline-block; margin:0;" onsubmit="return confirm('Apakah Anda yakin ingin {{ $user['is_active'] ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?');">
                    @csrf
                    <button type="submit" class="ats-btn ats-btn-secondary">
                        {{ $user['is_active'] ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom Section: Informasi Akun --}}
    <div class="ats-section-header">
        <h2>Informasi Akun</h2>
    </div>

    <div class="ats-info-grid">
        {{-- Item 1: Email --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-envelope"></i></div>
            <div class="ats-info-text">
                <h3>Alamat E-mail</h3>
                <p>{{ $user['email'] ?? '-' }}</p>
            </div>
        </div>
        
        {{-- Item 2: Phone --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-telephone"></i></div>
            <div class="ats-info-text">
                <h3>Telepon / WhatsApp</h3>
                <p>{{ $user['no_hp'] ?? '-' }}</p>
            </div>
        </div>
        
        {{-- Item 3: Address --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-geo-alt"></i></div>
            <div class="ats-info-text">
                <h3>Alamat Domisili</h3>
                <p>{{ $user['alamat'] ?? 'Belum ada alamat.' }}</p>
            </div>
        </div>

        {{-- Item 4: Joined Date --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="ats-info-text">
                <h3>Tanggal Registrasi</h3>
                <p>{{ \Carbon\Carbon::parse($user['created_at'])->locale('id')->isoFormat('D MMMM Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Timeline Riwayat Pesanan --}}
    <div class="ats-section-header" style="margin-top: 60px;">
        <h2>Aktivitas Pesanan</h2>
    </div>

    <div class="ats-timeline-wrap">
        @forelse(array_slice($orders ?? [], 0, 10) as $idx => $order)
            @php
                $bgColors = ['#f3f4f6', '#f8fafc', '#f1f5f9', '#fdf4ff'];
                $bgColor = $bgColors[$idx % 4];
                
                $badgeColor = '#64748b'; $badgeBg = '#e2e8f0';
                if($order['status_order'] === 'Selesai') { $badgeColor = '#10b981'; $badgeBg = '#d1fae5'; }
                elseif(in_array($order['status_order'], ['Sedang Dikerjakan', 'Teknisi Berangkat'])) { $badgeColor = '#3b82f6'; $badgeBg = '#dbeafe'; }
                elseif($order['status_order'] === 'Dibatalkan') { $badgeColor = '#ef4444'; $badgeBg = '#fee2e2'; }
            @endphp
            <div class="ats-tl-item">
                <div class="ats-tl-dot"></div>
                <div class="ats-tl-card" style="background: {{ $bgColor }};">
                    <div class="ats-tl-head">
                        <span class="ats-tl-title">{{ $order['nama_service'] ?? 'Layanan Servizz' }}</span>
                        <span class="ats-tl-badge" style="color: {{ $badgeColor }}; background: {{ $badgeBg }};">{{ $order['status_order'] }}</span>
                    </div>
                    <p class="ats-tl-desc">{{ Str::limit($order['catatan'] ?? 'Pesanan reguler', 80) }}</p>
                    <div class="ats-tl-foot">
                        <span class="ats-tl-price">Total: Rp {{ number_format($order['biaya_kunjungan'] ?? 0, 0, ',', '.') }}</span>
                        <a href="{{ route('orders.show', $order['id_order']) }}" class="ats-tl-link">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:40px; color:#9ca3af; border:1px dashed #d1d5db; border-radius:12px;">
                Belum ada aktivitas pesanan untuk pengguna ini.
            </div>
        @endforelse
    </div>

</div>

<style>
/* Base Styles */
.ats-profile-wrap {
    max-width: 1040px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #ffffff;
    min-height: 80vh;
}

/* Hero Section (Top) */
.ats-hero-section {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 60px;
    margin-bottom: 80px;
}
.ats-avatar-container {
    flex-shrink: 0;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    padding: 12px;
    background: #ffffff;
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.03);
    margin: 0 auto;
}
.ats-avatar-container img,
.ats-avatar-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.ats-avatar-placeholder {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
    font-weight: 800;
}
.ats-bio-container {
    flex: 1;
    min-width: 300px;
}
.ats-bio-role {
    font-size: 14px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.ats-bio-name {
    font-size: 48px;
    font-weight: 800;
    color: #111827;
    margin: 8px 0 20px 0;
    line-height: 1.1;
}
.ats-bio-desc {
    font-size: 16px;
    color: #6b7280;
    line-height: 1.7;
    margin-bottom: 32px;
    max-width: 600px;
}
.ats-bio-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}
.ats-btn {
    padding: 12px 28px;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}
.ats-btn-primary {
    border: 2px solid #10b981;
    color: #10b981;
    background: transparent;
}
.ats-btn-primary:hover {
    background: #10b981;
    color: #ffffff;
}
.ats-btn-secondary {
    border: 2px solid #e5e7eb;
    color: #4b5563;
    background: transparent;
}
.ats-btn-secondary:hover {
    border-color: #d1d5db;
    background: #f9fafb;
    color: #111827;
}

@media(max-width: 768px) {
    .ats-hero-section {
        text-align: center;
        flex-direction: column;
        gap: 40px;
    }
    .ats-bio-desc {
        margin: 0 auto 32px auto;
    }
    .ats-bio-buttons {
        justify-content: center;
    }
}

/* Section Header */
.ats-section-header {
    margin-bottom: 40px;
}
.ats-section-header h2 {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    display: inline-block;
    border-bottom: 3px solid #10b981;
    padding-bottom: 8px;
    margin: 0;
}

/* Info Grid */
.ats-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
}
.ats-info-item {
    display: flex;
    gap: 20px;
}
.ats-info-icon {
    font-size: 32px;
    color: #10b981;
    line-height: 1;
    margin-top: 4px;
}
.ats-info-text h3 {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 10px 0;
}
.ats-info-text p {
    font-size: 15px;
    color: #6b7280;
    line-height: 1.6;
    margin: 0;
}
@media(max-width: 768px) {
    .ats-info-grid {
        grid-template-columns: 1fr;
    }
}

/* Timeline Activity */
.ats-timeline-wrap {
    position: relative;
    padding-left: 24px;
}
.ats-timeline-wrap::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}
.ats-tl-item {
    position: relative;
    margin-bottom: 24px;
}
.ats-tl-dot {
    position: absolute;
    left: -29px;
    top: 24px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #10b981;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 2px #e5e7eb;
}
.ats-tl-card {
    border-radius: 12px;
    padding: 24px;
    border: 1px solid #f1f5f9;
}
.ats-tl-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.ats-tl-title {
    font-weight: 700;
    font-size: 16px;
    color: #1f2937;
}
.ats-tl-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 12px;
}
.ats-tl-desc {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 16px 0;
    line-height: 1.5;
}
.ats-tl-foot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid rgba(0,0,0,0.05);
}
.ats-tl-price {
    font-weight: 700;
    color: #374151;
    font-size: 14px;
}
.ats-tl-link {
    font-size: 13px;
    font-weight: 600;
    color: #10b981;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.ats-tl-link:hover {
    text-decoration: underline;
}
</style>
@endsection
