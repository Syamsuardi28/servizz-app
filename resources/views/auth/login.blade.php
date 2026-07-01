@extends('layouts.guest-split')

@section('title', 'Login')
@section('header_title', 'Welcome Back')
@section('header_subtitle', 'Masukkan kredensial Anda untuk melanjutkan')

@section('content')

<form method="POST" action="{{ route('login.post') }}" class="space-y-6 text-left">
    @csrf
    
    <!-- Email -->
    <div class="space-y-2 group">
        <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider group-focus-within:text-primary-400 transition-colors">Email Address</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 group-focus-within:text-primary-500 transition-colors">
                <i data-lucide="mail" class="w-5 h-5"></i>
            </div>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="block w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-2xl text-white text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 hover:border-white/20 hover:bg-white/10 transition-all placeholder-gray-600 outline-none" 
                placeholder="admin@servizz.com">
        </div>
    </div>

    <!-- Password -->
    <div class="space-y-2 group" x-data="{ show: false }">
        <div class="flex items-center justify-between">
            <label for="password" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider group-focus-within:text-primary-400 transition-colors">Password</label>
            <a href="{{ route('password.request') }}" class="text-xs font-medium text-primary-500 hover:text-primary-400 hover:underline hover:underline-offset-4 transition-all">Lupa password?</a>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-500 group-focus-within:text-primary-500 transition-colors">
                <i data-lucide="lock" class="w-5 h-5"></i>
            </div>
            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                class="block w-full pl-12 pr-12 py-3.5 bg-white/5 border border-white/10 rounded-2xl text-white text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 hover:border-white/20 hover:bg-white/10 transition-all placeholder-gray-600 outline-none" 
                placeholder="••••••••">
            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-white focus:outline-none transition-colors" title="Toggle Password">
                <i data-lucide="eye" x-show="!show" class="w-5 h-5"></i>
                <i data-lucide="eye-off" x-show="show" class="w-5 h-5" style="display: none;"></i>
            </button>
        </div>
    </div>

    <!-- Options -->
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-3 cursor-pointer group">
            <div class="relative flex items-center justify-center w-5 h-5 rounded-[6px] bg-white/5 border border-white/20 group-hover:border-primary-500 transition-colors overflow-hidden">
                <input type="checkbox" name="remember" class="peer absolute opacity-0 w-full h-full cursor-pointer">
                <div class="absolute inset-0 bg-primary-500 scale-0 peer-checked:scale-100 transition-transform duration-200 ease-out flex items-center justify-center">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
                </div>
            </div>
            <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">Ingat saya di perangkat ini</span>
        </label>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button type="submit" class="group relative w-full flex items-center justify-center gap-2 py-4 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 text-white font-bold rounded-2xl shadow-lg shadow-primary-500/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-primary-500/40 active:scale-[0.98] overflow-hidden">
            <!-- Ripple/Glow effect base -->
            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
            
            <i data-lucide="log-in" class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform"></i>
            <span class="relative z-10">Masuk ke Dashboard</span>
        </button>
    </div>
</form>

<!-- Social Login Divider -->
<div class="mt-8 mb-6 relative flex items-center justify-center">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-white/10"></div>
    </div>
    <div class="relative bg-[#0a0a0a]/50 backdrop-blur-md px-4 text-xs font-medium text-gray-500 uppercase tracking-widest rounded-full">
        Atau masuk dengan
    </div>
</div>

<!-- Social Buttons -->
<div class="mt-6 flex flex-col sm:flex-row gap-4">
    <a href="{{ route('social.redirect', 'google') }}" class="group flex-1 flex justify-center items-center gap-3 py-3.5 px-4 bg-white/5 border border-white/10 rounded-2xl shadow-sm text-sm font-semibold text-gray-300 hover:bg-white/10 hover:text-white hover:border-white/20 transition-all duration-300">
        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Google
    </a>
</div>

<!-- Register Link -->
<div class="mt-8 text-center text-sm text-gray-500">
    Belum tergabung? <a href="{{ route('register') }}" class="font-bold text-white hover:text-primary-400 hover:underline hover:underline-offset-4 transition-all">Mulai ujicoba gratis</a>
</div>

<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>

@endsection
