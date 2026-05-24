@extends('settings.layout')

@push('setting_styles')
<style>
    .notif-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
        border-bottom: 1px solid var(--svz-border);
    }
    .notif-group:last-child {
        border-bottom: none;
    }
    .notif-info h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--svz-txt);
        margin: 0 0 4px 0;
    }
    .notif-info p {
        font-size: 13px;
        color: var(--svz-muted);
        margin: 0;
    }
    
    /* Modern Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    input:checked + .slider {
        background-color: var(--svz-primary);
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
</style>
@endpush

@section('setting_content')
<h2 style="font-size: 20px; font-weight: 700; color: var(--svz-txt); margin-bottom: 24px;">Preferensi Notifikasi</h2>

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

<div style="margin-top: 32px; background: #f8fafc; padding: 16px; border-radius: 8px; font-size: 13px; color: var(--svz-muted);">
    <i class="bi bi-info-circle" style="margin-right: 6px;"></i> Pengaturan notifikasi saat ini otomatis tersimpan secara lokal di peramban Anda.
</div>
@endsection
