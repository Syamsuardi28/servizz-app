@extends('layouts.guest')
@section('title', 'Atur Ulang Password')

@section('content')
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 mb-6 shadow-inner">
        <i data-lucide="lock" class="w-8 h-8"></i>
    </div>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-3">Atur Ulang Sandi</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm">Masukkan kata sandi baru untuk akun Anda.</p>
</div>

<form method="POST" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    
    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
            </div>
            <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" readonly class="block w-full pl-11 pr-4 py-3 bg-gray-100 dark:bg-[#1f1f1e] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-gray-500 dark:text-gray-400 transition-all sm:text-sm">
        </div>
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kata Sandi Baru</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
            </div>
            <input type="password" name="password" id="password" required autofocus class="block w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm" placeholder="Minimal 6 karakter">
        </div>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Kata Sandi</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="check-circle" class="w-5 h-5 text-gray-400"></i>
            </div>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all sm:text-sm" placeholder="Ulangi kata sandi baru">
        </div>
    </div>

    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md shadow-primary-500/20 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:-translate-y-0.5">
        <i data-lucide="save" class="w-4 h-4"></i>
        Simpan Kata Sandi
    </button>
</form>
@endsection
