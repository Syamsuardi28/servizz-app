@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('breadcrumb', 'Pengaturan Akun')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Pengaturan Akun</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola preferensi akun, profil, dan keamanan Anda.</p>
    </div>

    <!-- Unified Settings Container -->
    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] overflow-hidden flex flex-col lg:flex-row min-h-[600px]">
        
        <!-- Left Sidebar Navigation -->
        <div class="w-full lg:w-72 bg-gray-50/50 dark:bg-[#20201f]/30 border-b lg:border-b-0 lg:border-r border-gray-100 dark:border-[#3E3E3A] shrink-0">
            <nav class="flex lg:flex-col gap-1 overflow-x-auto lg:overflow-visible p-4 hide-scrollbar">
                
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors shrink-0 {{ request()->routeIs('settings.index') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 shadow-sm border border-primary-100 dark:border-primary-900/30' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#262625] border border-transparent' }}">
                    <i data-lucide="user" class="w-5 h-5 {{ request()->routeIs('settings.index') ? 'text-primary-500 dark:text-primary-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    <span class="text-sm">Profil Pribadi</span>
                </a>
                
                <a href="{{ route('settings.password') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors shrink-0 {{ request()->routeIs('settings.password') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 shadow-sm border border-primary-100 dark:border-primary-900/30' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#262625] border border-transparent' }}">
                    <i data-lucide="lock" class="w-5 h-5 {{ request()->routeIs('settings.password') ? 'text-primary-500 dark:text-primary-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    <span class="text-sm">Keamanan & Sandi</span>
                </a>
                
                <a href="{{ route('settings.notifications') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors shrink-0 {{ request()->routeIs('settings.notifications') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 shadow-sm border border-primary-100 dark:border-primary-900/30' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#262625] border border-transparent' }}">
                    <i data-lucide="bell" class="w-5 h-5 {{ request()->routeIs('settings.notifications') ? 'text-primary-500 dark:text-primary-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    <span class="text-sm">Notifikasi</span>
                </a>
                
                <a href="{{ route('settings.verification') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors shrink-0 {{ request()->routeIs('settings.verification') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 shadow-sm border border-primary-100 dark:border-primary-900/30' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#262625] border border-transparent' }}">
                    <i data-lucide="shield-check" class="w-5 h-5 {{ request()->routeIs('settings.verification') ? 'text-primary-500 dark:text-primary-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    <span class="text-sm">Verifikasi Dokumen</span>
                </a>

            </nav>
        </div>

        <!-- Right Main Content -->
        <div class="flex-1 min-w-0 p-6 sm:p-8 lg:p-10 bg-white dark:bg-[#161615]">
            @yield('setting_content')
        </div>

    </div>
</div>
@endsection
