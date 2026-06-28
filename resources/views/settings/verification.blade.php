
@push('styles')
    @vite('resources/css/settings.css')
@endpush
@extends('settings.layout')

@push('setting_styles')
@endpush

@section('setting_content')
<h2 style="font-size: 20px; font-weight: 700; color: var(--txt); margin-bottom: 24px;">Status Verifikasi Akun</h2>

<div style="max-width: 700px;">

    {{-- Email Verification (All Users) --}}
    <div class="verify-card">
        <div class="verify-icon verified">
            <i class="bi bi-envelope-check"></i>
        </div>
        <div class="verify-text">
            <h3>Email Terverifikasi</h3>
            <p>{{ $user['email'] ?? 'Alamat email Anda telah diverifikasi.' }}</p>
        </div>
        <div class="verify-status verified">Terverifikasi</div>
    </div>

    {{-- Phone Number Verification --}}
    <div class="verify-card">
        <div class="verify-icon verified">
            <i class="bi bi-telephone-check"></i>
        </div>
        <div class="verify-text">
            <h3>Nomor Telepon</h3>
            <p>{{ $user['no_hp'] ?? 'Nomor telepon terdaftar dan aktif.' }}</p>
        </div>
        <div class="verify-status verified">Terverifikasi</div>
    </div>

    @if(($user['role'] ?? '') === 'Mitra')
    @php
        $st = $user['status_verifikasi'] ?? 'Pending';
        $vStyle = [
            'Terverifikasi' => ['icon'=>'verified', 'bg'=>'verified', 'text'=>'Terverifikasi'],
            'Pending'       => ['icon'=>'pending', 'bg'=>'pending', 'text'=>'Menunggu Tinjauan'],
            'Ditolak'       => ['icon'=>'unverified', 'bg'=>'unverified', 'text'=>'Ditolak']
        ];
        $s = $vStyle[$st] ?? $vStyle['Pending'];
    @endphp
    {{-- Mitra specific verifications --}}
    <div class="verify-card">
        <div class="verify-icon {{ $s['icon'] }}">
            <i class="bi bi-file-earmark-person"></i>
        </div>
        <div class="verify-text">
            <h3>Dokumen Kemitraan (SKCK & Sertifikat)</h3>
            @if($st === 'Terverifikasi')
                <p>Dokumen Anda telah diverifikasi oleh tim admin.</p>
            @elseif($st === 'Ditolak')
                <p>Verifikasi ditolak. Silakan unggah dokumen yang valid kembali.</p>
            @else
                <p>Tinjau dokumen Anda atau unggah yang baru.</p>
            @endif
        </div>
        <div class="verify-status {{ $s['bg'] }}">{{ $s['text'] }}</div>
    </div>

    {{-- Form Unggah Dokumen --}}
    <div class="verify-card" style="display: block;">
        <h3 style="margin-top:0; font-size:16px; font-weight:700; margin-bottom:16px;">Kelola Dokumen Verifikasi</h3>
        <form action="{{ route('settings.verification.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- SKCK --}}
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:600; margin-bottom:8px; font-size:14px;">File SKCK</label>
                @if(!empty($user['foto_skck']))
                    <div style="margin-bottom:8px; font-size:13px; color:#16a34a;"><i class="bi bi-check-circle-fill"></i> SKCK sudah diunggah. <a href="{{ $user['foto_skck'] }}" target="_blank" style="color:var(--svz-primary); text-decoration:none;">Lihat SKCK</a></div>
                @endif
                <input type="file" name="foto_skck" accept="image/*,application/pdf" style="display:block; width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px;">
                <small style="color:#64748b;">Unggah file baru untuk memperbarui (Maks. 10MB, PDF/JPG/PNG).</small>
            </div>

            {{-- Sertifikat --}}
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-weight:600; margin-bottom:8px; font-size:14px;">Sertifikat Keahlian</label>
                @if(!empty($user['sertifikat_url']))
                    <div style="margin-bottom:8px; font-size:13px; color:#16a34a;"><i class="bi bi-check-circle-fill"></i> Sertifikat sudah diunggah. <a href="{{ $user['sertifikat_url'] }}" target="_blank" style="color:var(--svz-primary); text-decoration:none;">Lihat Sertifikat</a></div>
                @endif
                <input type="file" name="sertifikat" accept="image/*,application/pdf" style="display:block; width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px;">
                <small style="color:#64748b;">Unggah file baru untuk memperbarui (Maks. 10MB, PDF/JPG/PNG).</small>
            </div>

            <button type="submit" style="background:var(--svz-primary); color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Unggah Dokumen</button>
        </form>
    </div>
    @endif

</div>
@endsection
