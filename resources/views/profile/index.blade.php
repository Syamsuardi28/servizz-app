@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb', 'Profil Saya')


@push('styles')
    @vite('resources/css/profile.css')
@endpush

@section('content')

<div class="ats-profile-wrap">

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
            <span class="ats-bio-role">{{ session('servizz_user.role') ?? 'Pengguna' }}</span>
            <h1 class="ats-bio-name">{{ $user['nama'] ?? 'Pengguna Servizz' }}</h1>
            <p class="ats-bio-desc">
                Selamat datang di panel profil Servizz Anda. Pastikan informasi kontak Anda selalu valid agar layanan yang kami berikan dapat berjalan dengan maksimal. Anda dapat memperbarui informasi di halaman pengaturan akun.
            </p>
            <div class="ats-bio-buttons">
                <a href="{{ route('settings.index') }}" class="ats-btn ats-btn-primary">Edit Profil</a>
                <a href="#" class="ats-btn ats-btn-secondary" onclick="alert('Silakan hubungi cs@servizz.io untuk bantuan.'); return false;">Kontak Bantuan</a>
            </div>
        </div>
    </div>

    {{-- Bottom Section: What I Do / Informasi Akun --}}
    <div class="ats-section-header">
        <h2>Informasi Akun</h2>
    </div>

    <div class="ats-info-grid">
        {{-- Item 1: Email --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-envelope"></i></div>
            <div class="ats-info-text">
                <h3>Alamat E-mail</h3>
                <p>{{ $user['email'] ?? 'Belum ada email yang ditambahkan. Segera tambahkan untuk keamanan ekstra.' }}</p>
            </div>
        </div>
        
        {{-- Item 2: Phone --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-telephone"></i></div>
            <div class="ats-info-text">
                <h3>Telepon / WhatsApp</h3>
                <p>{{ $user['no_hp'] ?? 'Belum ada nomor telepon. Tambahkan agar teknisi dapat menghubungi Anda dengan mudah.' }}</p>
            </div>
        </div>
        
        {{-- Item 3: Address --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-geo-alt"></i></div>
            <div class="ats-info-text">
                <h3>Alamat Domisili</h3>
                <p>{{ $user['alamat'] ?? 'Belum ada alamat. Pastikan alamat terisi agar layanan on-site dapat menuju ke lokasi yang tepat.' }}</p>
            </div>
        </div>

        {{-- Item 4: Joined Date --}}
        <div class="ats-info-item">
            <div class="ats-info-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="ats-info-text">
                <h3>Tanggal Registrasi</h3>
                <p>Akun Anda didaftarkan secara resmi pada {{ \Carbon\Carbon::parse($user['created_at'])->locale('id')->isoFormat('D MMMM Y') }}.</p>
            </div>
        </div>
    </div>

    {{-- Timeline Riwayat Pesanan (Hanya untuk Pelanggan / Mitra) --}}
    @if(in_array(session('servizz_user.role'), ['Pelanggan', 'Mitra']))
    <div class="ats-section-header" style="margin-top: 60px;">
        <h2>{{ session('servizz_user.role') === 'Mitra' ? 'Riwayat Pekerjaan' : 'Aktivitas Pesanan' }}</h2>
    </div>

    <div class="ats-timeline-wrap">
        @forelse(array_slice($orders ?? [], 0, 5) as $idx => $order)
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
                Belum ada aktivitas yang terekam.
            </div>
        @endforelse
    </div>
    @endif

</div>

@endsection
