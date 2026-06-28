@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('breadcrumb', 'Pengaturan Akun')

@push('styles')
    @vite('resources/css/settings.css')
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
