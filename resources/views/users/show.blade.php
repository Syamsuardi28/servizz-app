@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('breadcrumb', 'Pengguna / Detail')


@push('styles')
    @vite('resources/css/users.css')
@endpush

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

@endsection
