@extends('layouts.guest-split')

@section('title', 'Login')
@section('header_title', 'Selamat Datang Kembali')
@section('header_subtitle', 'Masuk ke akun Anda untuk melanjutkan')

@section('content')

<form method="POST" action="{{ route('login.post') }}" class="space-y-5 text-left">
    @csrf
    
    <!-- Email -->
    <div class="space-y-1.5">
        <label for="email" class="block text-sm font-semibold text-[#EDEDEC]">Email Address</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                <i data-lucide="mail" class="w-5 h-5"></i>
            </div>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="block w-full pl-11 pr-4 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm" 
                placeholder="Contoh: admin@servizz.com">
        </div>
    </div>

    <!-- Password -->
    <div class="space-y-1.5" x-data="{ show: false }">
        <label for="password" class="block text-sm font-semibold text-[#EDEDEC]">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                <i data-lucide="lock" class="w-5 h-5"></i>
            </div>
            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                class="block w-full pl-11 pr-11 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm" 
                placeholder="••••••••">
            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-500 hover:text-gray-300 focus:outline-none transition-colors">
                <i data-lucide="eye" x-show="!show" class="w-5 h-5"></i>
                <i data-lucide="eye-off" x-show="show" class="w-5 h-5" style="display: none;"></i>
            </button>
        </div>
    </div>

    <!-- Options -->
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer group">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-primary-600 bg-gray-50 dark:bg-[#161615] border-gray-300 dark:border-[#3E3E3A] focus:ring-primary-500 focus:ring-offset-gray-50 dark:focus:ring-offset-[#161615] transition-colors">
            <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Ingat saya</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary-500 hover:text-primary-400 transition-colors">Lupa password?</a>
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary-500/20 transition-all active:scale-[0.98]">
        <i data-lucide="log-in" class="w-5 h-5"></i>
        Masuk
    </button>
</form>

<!-- Social Login Divider -->
<div class="mt-8 mb-6 relative flex items-center justify-center">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-[#3E3E3A]"></div>
    </div>
    <div class="relative bg-[#161615] px-4 text-xs font-medium text-gray-500">
        Atau masuk dengan
    </div>
</div>

<!-- Social Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('social.redirect', 'google') }}" class="flex-1 flex justify-center items-center gap-2 py-2.5 px-4 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl shadow-sm text-sm font-semibold text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-50 dark:hover:bg-[#1f1f1e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:focus:ring-[#3E3E3A] transition-all">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Google
        </a>
    </div>

<!-- Register Link -->
<div class="mt-8 text-center text-sm text-gray-400">
    Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-primary-500 hover:text-primary-400 transition-colors">Daftar sekarang</a>
</div>

@endsection
