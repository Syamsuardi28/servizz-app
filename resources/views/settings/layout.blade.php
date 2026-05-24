@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('breadcrumb', 'Pengaturan Akun')

@push('styles')
<style>
    .settings-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }
    .settings-page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--svz-txt);
        margin-bottom: 24px;
    }
    .settings-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    
    /* Left Sidebar */
    .settings-sidebar {
        width: 250px;
        background: #ffffff;
        border-radius: 16px;
        padding: 12px 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        flex-shrink: 0;
    }
    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 24px;
        color: var(--svz-nav-txt);
        text-decoration: none;
        font-weight: 500;
        font-size: 14.5px;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    .settings-nav-item i {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }
    .settings-nav-item:hover {
        background: #f8fafc;
        color: var(--svz-txt);
    }
    .settings-nav-item.active {
        color: var(--svz-primary);
        background: var(--svz-primary-bg);
        border-left-color: var(--svz-primary);
        font-weight: 600;
    }

    /* Main Content */
    .settings-content {
        flex: 1;
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    /* Common Components */
    .st-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }
    .st-label {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--svz-txt);
    }
    .st-label span.req {
        color: #ef4444;
    }
    .st-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: var(--svz-txt);
        font-family: inherit;
        transition: all 0.2s;
        background: #fff;
    }
    .st-input:focus {
        outline: none;
        border-color: var(--svz-primary);
        box-shadow: 0 0 0 3px var(--svz-primary-bg);
    }
    .st-input:disabled {
        background: #f8fafc;
        color: var(--svz-muted);
        cursor: not-allowed;
    }
    .btn-save {
        background: var(--svz-primary);
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        margin-top: 16px;
        transition: background 0.2s;
    }
    .btn-save:hover {
        background: #3f3973;
    }

    @media (max-width: 768px) {
        .settings-layout {
            flex-direction: column;
        }
        .settings-sidebar {
            width: 100%;
        }
    }
</style>
@stack('setting_styles')
@endpush

@section('content')
<div class="settings-wrapper">

    <div class="settings-layout">
        {{-- LEFT SIDEBAR NAV --}}
        <div class="settings-sidebar">
            <a href="{{ route('settings.index') }}" class="settings-nav-item {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Pengaturan Profil
            </a>
            <a href="{{ route('settings.password') }}" class="settings-nav-item {{ request()->routeIs('settings.password') ? 'active' : '' }}">
                <i class="bi bi-lock"></i> Kata Sandi
            </a>
            <a href="{{ route('settings.notifications') }}" class="settings-nav-item {{ request()->routeIs('settings.notifications') ? 'active' : '' }}">
                <i class="bi bi-bell"></i> Notifikasi
            </a>
            <a href="{{ route('settings.verification') }}" class="settings-nav-item {{ request()->routeIs('settings.verification') ? 'active' : '' }}">
                <i class="bi bi-patch-check"></i> Verifikasi
            </a>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="settings-content">
            @yield('setting_content')
        </div>
    </div>
</div>
@endsection
