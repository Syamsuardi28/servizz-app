
@push('styles')
    @vite('resources/css/settings.css')
@endpush
@extends('settings.layout')

@push('setting_styles')
@endpush

@section('setting_content')
<h2 style="font-size: 20px; font-weight: 700; color: var(--txt); margin-bottom: 24px;">Preferensi Notifikasi</h2>

<div class="notif-container" style="max-width: 600px;">
    
    <div class="notif-group">
        <div class="notif-info">
            <h3>Notifikasi Email</h3>
            <p>Terima pembaruan pesanan dan penawaran langsung ke email Anda.</p>
        </div>
        <label class="toggle-switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
        </label>
    </div>

    <div class="notif-group">
        <div class="notif-info">
            <h3>Notifikasi Push Aplikasi</h3>
            <p>Terima notifikasi instan saat aplikasi terbuka (Real-time).</p>
        </div>
        <label class="toggle-switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
        </label>
    </div>

    <div class="notif-group">
        <div class="notif-info">
            <h3>Pembaruan Sistem</h3>
            <p>Berita terbaru, tips penggunaan, dan pembaruan fitur dari SERVIZZ.</p>
        </div>
        <label class="toggle-switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
    </div>

</div>

<div style="margin-top: 32px; background: #f8fafc; padding: 16px; border-radius: 8px; font-size: 13px; color: var(--muted);">
    <i class="bi bi-info-circle" style="margin-right: 6px;"></i> Pengaturan notifikasi saat ini otomatis tersimpan secara lokal di peramban Anda.
</div>
@endsection
