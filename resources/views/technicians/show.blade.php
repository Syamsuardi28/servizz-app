{{-- Lokasi: resources/views/technicians/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Mitra — ' . ($tech['nama'] ?? ''))
@section('breadcrumb', 'Mitra / Teknisi / ' . ($tech['nama'] ?? ''))

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

<style>
/* ── Layout Wrapper ── */
.ats-profile-wrap {
    display: flex;
    gap: 32px;
    background: #f8f9fc;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    align-items: flex-start;
}

/* ── Sidebar (Left Column) ── */
.ats-sidebar {
    width: 280px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 32px 24px;
    flex-shrink: 0;
}
.ats-sidebar-header {
    text-align: center;
    margin-bottom: 24px;
}
.ats-avatar-container {
    width: 120px;
    height: 120px;
    margin: 0 auto 16px auto;
    border-radius: 50%;
    background: url('https://www.transparenttextures.com/patterns/cubes.png'), linear-gradient(135deg, #1e293b, #334155);
    padding: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.ats-avatar {
    width: 100%;
    height: 100%;
    background: #475569;
    border-radius: 50%;
    border: 3px solid #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    overflow: hidden;
}
.ats-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ats-name {
    font-size: 20px;
    font-weight: 700;
    color: #334155;
    margin: 0 0 6px 0;
}
.ats-studentid {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    margin: 0 0 12px 0;
    text-transform: uppercase;
}
.ats-status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}
.ats-status-badge.green { background: #dcfce7; color: #15803d; }
.ats-status-badge.orange { background: #fef3c7; color: #b45309; }
.ats-status-badge.red { background: #fee2e2; color: #b91c1c; }

.ats-divider {
    border: 0;
    border-top: 1px solid #f1f5f9;
    margin: 24px 0;
}
.ats-section {
    margin-bottom: 20px;
}
.ats-section-title {
    font-size: 11px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
    letter-spacing: 0.5px;
}
.ats-section-value {
    font-size: 13px;
    font-weight: 400;
    color: #475569;
    margin: 0;
    line-height: 1.5;
}

.ats-sidebar-footer {
    margin-top: 40px;
}
.ats-bottom-btn {
    width: 100%;
    display: block;
    text-align: center;
    background: transparent;
    border: 1px solid #94a3b8;
    border-radius: 24px;
    padding: 10px;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    letter-spacing: 0.5px;
    transition: all 0.2s;
}
.ats-bottom-btn:hover {
    background: #f1f5f9;
    border-color: #64748b;
    color: #1e293b;
}
.ats-select { 
    width: 100%; 
    padding: 10px 12px; 
    border-radius: 8px; 
    border: 1px solid #cbd5e1; 
    background-color: #ffffff;
    outline: none; 
    font-size: 13px; 
    color: #334155;
    font-family: inherit;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px;
    transition: all 0.2s;
}
.ats-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}
.ats-btn-primary { width: 100%; background: #4f46e5; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 700; font-size:12px; cursor: pointer; transition: background 0.2s; }
.ats-btn-primary:hover { background: #4338ca; }

/* ── Content (Right Column) ── */
.ats-content {
    flex: 1;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 40px;
    min-height: 600px;
}

/* Tabs */
.ats-tabs {
    display: flex;
    gap: 24px;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 32px;
}
.ats-tab {
    background: none;
    border: none;
    padding: 0 0 12px 0;
    font-size: 14px;
    font-weight: 600;
    color: #94a3b8;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
}
.ats-tab.active {
    color: #4c1d95; /* Deep Purple */
    border-bottom-color: #4c1d95;
}
.ats-tab:hover:not(.active) {
    color: #475569;
}

/* Tab Content */
.ats-tab-content {
    display: none;
}
.ats-tab-content.active {
    display: block;
    animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

.ats-page-title {
    font-size: 24px;
    font-weight: 400;
    color: #475569;
    margin: 0 0 32px 0;
}
.ats-sub-title {
    font-size: 11px;
    font-weight: 800;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 6px 0;
}
.ats-sub-desc {
    font-size: 13px;
    color: #475569;
    line-height: 1.5;
    margin: 0 0 16px 0;
}
.ats-req-text {
    font-size: 13px;
    color: #1e293b;
    margin: 0 0 8px 0;
}

/* Purple Pills */
.ats-pill-row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.ats-pill {
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.5px;
}
.ats-pill.purple {
    background: #4c1d95;
    color: #ffffff;
    cursor: pointer;
    transition: background 0.2s;
}
.ats-pill.purple:hover {
    background: #3b0764;
}
.ats-pill.gray {
    background: #f1f5f9;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
}
.ats-pill.dashed {
    background: transparent;
    color: #94a3b8;
    border: 1px dashed #cbd5e1;
}

/* Stats Box */
.ats-stats-row {
    display: flex;
    gap: 16px;
}
.ats-stat-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    flex: 1;
    text-align: center;
}
.ats-stat-number {
    display: block;
    font-size: 24px;
    font-weight: 800;
    color: #4c1d95;
    margin-bottom: 4px;
}
.ats-stat-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
}

/* Reviews List */
.ats-reviews-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.ats-review-item {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
}
.ats-review-head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}
.ats-review-head strong { font-size: 14px; color: #1e293b; }
.ats-stars { color: #f59e0b; font-size: 14px; }
.ats-review-body { font-size: 13px; color: #475569; line-height: 1.5; margin-bottom: 8px; }
.ats-review-date { font-size: 11px; color: #94a3b8; }

/* Responsive */
@media (max-width: 768px) {
    .ats-profile-wrap { flex-direction: column; }
    .ats-sidebar { width: 100%; border-radius: 0; border-left: none; border-right: none; }
    .ats-content { border-radius: 0; border-left: none; border-right: none; padding: 24px; }
}
</style>

@endsection