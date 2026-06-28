{{-- Lokasi: resources/views/technicians/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Mitra — ' . ($tech['nama'] ?? ''))
@section('breadcrumb', 'Mitra / Teknisi / ' . ($tech['nama'] ?? ''))


@push('styles')
    @vite('resources/css/technicians.css')
@endpush

@section('content')
@php
    $st = $tech['status_verifikasi'] ?? 'Pending';
    $initials = strtoupper(substr($tech['nama'] ?? 'M', 0, 1));
@endphp

<div style="margin-bottom: 20px;">
    <a href="{{ route('technicians.index') }}" style="display:inline-flex; align-items:center; gap:8px; text-decoration:none; color:#64748b; font-weight:600; font-size:14px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Mitra
    </a>
</div>

<div class="ats-profile-wrap">
    
    {{-- LEFT COLUMN: Sidebar Profile --}}
    <div class="ats-sidebar">
        
        {{-- Avatar & Name --}}
        <div class="ats-sidebar-header">
            <div class="ats-avatar-container">
                <div class="ats-avatar">
                    @if(empty($tech['foto_profil']))
                        {{ $initials }}
                    @else
                        <img src="{{ $tech['foto_profil'] }}" alt="Profile">
                    @endif
                </div>
            </div>
            <h1 class="ats-name">{{ $tech['nama'] ?? '—' }}</h1>
            <p class="ats-studentid">ID Mitra: {{ $tech['id_tech'] ?? '-' }}</p>
            @if($st === 'Terverifikasi')
                <span class="ats-status-badge green">Terverifikasi</span>
            @elseif($st === 'Pending')
                <span class="ats-status-badge orange">Pending</span>
            @else
                <span class="ats-status-badge red">Ditolak</span>
            @endif
        </div>

        {{-- Divider --}}
        <hr class="ats-divider">

        {{-- Section: KEAHLIAN & PENGALAMAN --}}
        <div class="ats-section">
            <h3 class="ats-section-title">KEAHLIAN UTAMA</h3>
            <p class="ats-section-value">{{ $tech['keahlian'] ?? 'Umum' }}</p>
        </div>
        
        <div class="ats-section">
            <h3 class="ats-section-title">PENGALAMAN</h3>
            <p class="ats-section-value">{{ $tech['pengalaman_tahun'] ?? '0' }} Tahun</p>
        </div>

        <hr class="ats-divider">

        {{-- Section: KONTAK --}}
        <div class="ats-section">
            <h3 class="ats-section-title">ALAMAT DOMISILI</h3>
            <p class="ats-section-value">{{ $tech['alamat'] ?? '—' }}</p>
        </div>

        <div class="ats-section">
            <h3 class="ats-section-title">NO HP / WHATSAPP</h3>
            <p class="ats-section-value">{{ $tech['no_hp'] ?? '—' }}</p>
        </div>

        <div class="ats-section">
            <h3 class="ats-section-title">EMAIL</h3>
            <p class="ats-section-value">{{ $tech['email'] ?? '—' }}</p>
        </div>

        {{-- Action Button --}}
        <div class="ats-sidebar-footer">
            @if(session('servizz_user.role') === 'Admin')
                <button class="ats-bottom-btn" onclick="document.getElementById('verifyForm').style.display = document.getElementById('verifyForm').style.display === 'block' ? 'none' : 'block'">
                    UBAH STATUS MITRA
                </button>
                <div id="verifyForm" style="display: none; margin-top: 12px;">
                    <form method="POST" action="{{ route('technicians.verify', $tech['id_tech']) }}">
                        @csrf
                        <select name="status" class="ats-select" style="margin-bottom: 8px;">
                            <option value="Terverifikasi" {{ $st==='Terverifikasi'?'selected':'' }}>Terverifikasi</option>
                            <option value="Pending" {{ $st==='Pending'?'selected':'' }}>Pending</option>
                            <option value="Ditolak" {{ $st==='Ditolak'?'selected':'' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="ats-btn-primary">SIMPAN STATUS</button>
                    </form>
                </div>
            @else
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $tech['no_hp'] ?? '') }}" target="_blank" class="ats-bottom-btn">
                    HUBUNGI WHATSAPP
                </a>
            @endif
        </div>
    </div>

    {{-- RIGHT COLUMN: Tabs & Content --}}
    <div class="ats-content">
        
        {{-- Tabs Header --}}
        <div class="ats-tabs">
            <button class="ats-tab active" onclick="switchTab('academicStats', this)">Statistik & Ulasan</button>
            <button class="ats-tab" onclick="switchTab('programRequirements', this)">Dokumen Persyaratan</button>
        </div>

        {{-- Tab Content 1: Academic Stats (Ulasan & Rating) --}}
        <div id="academicStats" class="ats-tab-content active">
            <h2 class="ats-page-title">Statistik Kinerja Teknisi</h2>
            
            <div class="ats-sub-section">
                <h3 class="ats-sub-title">RINGKASAN RATING</h3>
                <p class="ats-sub-desc">Berikut adalah rekapitulasi nilai ulasan yang diberikan oleh pelanggan setelah pesanan diselesaikan.</p>
                
                <div class="ats-stats-row">
                    <div class="ats-stat-box">
                        <span class="ats-stat-number">⭐ {{ number_format($ratingData['rata_rata'] ?? 0, 2) }}</span>
                        <span class="ats-stat-label">Rating Rata-rata</span>
                    </div>
                    <div class="ats-stat-box">
                        <span class="ats-stat-number">{{ $ratingData['total_rating'] ?? 0 }}</span>
                        <span class="ats-stat-label">Total Ulasan</span>
                    </div>
                    <div class="ats-stat-box">
                        <span class="ats-stat-number">{{ $tech['total_order_selesai'] ?? 0 }}</span>
                        <span class="ats-stat-label">Order Selesai</span>
                    </div>
                </div>
            </div>

            <div class="ats-sub-section" style="margin-top: 40px;">
                <h3 class="ats-sub-title">RIWAYAT ULASAN</h3>
                @if(!empty($ratingData['ratings']) && count($ratingData['ratings']))
                    <div class="ats-reviews-list">
                        @foreach($ratingData['ratings'] as $r)
                        <div class="ats-review-item">
                            <div class="ats-review-head">
                                <strong>{{ $r['nama_pelanggan'] }}</strong>
                                <span class="ats-stars">
                                    @for($i=1; $i<=5; $i++)
                                        {{ $i <= $r['nilai'] ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            <div class="ats-review-body">"{{ $r['komentar'] ?? 'Tidak ada komentar.' }}"</div>
                            <div class="ats-review-date">{{ date('d M Y H:i', strtotime($r['created_at'])) }}</div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="ats-sub-desc" style="margin-top: 12px; font-style: italic;">Belum ada ulasan pelanggan.</p>
                @endif
            </div>
        </div>

        {{-- Tab Content 2: Program Requirements (Dokumen Verifikasi) --}}
        <div id="programRequirements" class="ats-tab-content">
            <h2 class="ats-page-title">Dokumen Verifikasi Mitra</h2>
            
            <div class="ats-sub-section">
                <h3 class="ats-sub-title">SYARAT PENDAFTARAN WAJIB</h3>
                <p class="ats-sub-desc">Berikut adalah dokumen yang diperlukan untuk memverifikasi pendaftaran sebagai Mitra Servizz. Klik kotak dokumen untuk mengunduh atau melihat file.</p>
                
                <p class="ats-req-text">File Surat Keterangan Catatan Kepolisian (SKCK):</p>
                <div class="ats-pill-row">
                    @if(!empty($tech['foto_skck']))
                        <a href="{{ $tech['foto_skck'] }}" target="_blank" class="ats-pill purple">
                            SKCK ✔
                        </a>
                    @else
                        <div class="ats-pill gray">SKCK (Kosong)</div>
                    @endif
                </div>

                <p class="ats-req-text" style="margin-top: 24px;">File Sertifikat Keahlian / Kompetensi Teknis:</p>
                <div class="ats-pill-row">
                    @if(!empty($tech['sertifikat_url']))
                        <a href="{{ $tech['sertifikat_url'] }}" target="_blank" class="ats-pill purple">
                            Sertifikat ✔
                        </a>
                    @else
                        <div class="ats-pill gray">Sertifikat (Kosong)</div>
                    @endif
                </div>
            </div>

            <div class="ats-sub-section" style="margin-top: 40px;">
                <h3 class="ats-sub-title">PERSYARATAN TAMBAHAN LAINNYA</h3>
                <p class="ats-sub-desc">Dokumen pendukung lainnya (Opsional).</p>
                
                <p class="ats-req-text">1.0 File Identitas atau Portofolio:</p>
                <div class="ats-pill-row">
                    <div class="ats-pill dashed">BELUM TERSEDIA</div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function switchTab(tabId, el) {
        document.querySelectorAll('.ats-tab-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.ats-tab').forEach(t => t.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        el.classList.add('active');
    }
</script>

@endsection