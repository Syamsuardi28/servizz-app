@extends('layouts.guest-split')

@section('title', 'Register')
@section('header_title', 'Buat Akun Baru')
@section('header_subtitle', 'Bergabunglah dengan ekosistem Servizz.io')

@section('content')

<form method="POST" action="{{ route('register.post') }}" class="space-y-5 text-left" enctype="multipart/form-data">
    @csrf
    
    <div x-data="{ role: 'Pelanggan' }">
        <!-- Role Selection -->
        <div class="grid grid-cols-2 gap-2 mb-5 p-1 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl">
            <label class="cursor-pointer">
                <input type="radio" name="role" value="Pelanggan" x-model="role" class="peer sr-only">
                <div class="py-2 text-center text-sm font-bold rounded-lg transition-all peer-checked:bg-white peer-checked:text-gray-900 peer-checked:shadow text-gray-400 hover:text-gray-300">
                    Pelanggan
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="role" value="Mitra" x-model="role" class="peer sr-only">
                <div class="py-2 text-center text-sm font-bold rounded-lg transition-all peer-checked:bg-primary-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-primary-500/30 text-gray-400 hover:text-gray-300">
                    Mitra Jasa
                </div>
            </label>
        </div>

        <!-- Nama Lengkap -->
        <div class="space-y-1.5">
            <label for="nama" class="block text-sm font-semibold text-[#EDEDEC]">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required autofocus
                    class="block w-full pl-11 pr-4 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm" 
                    placeholder="Contoh: John Doe">
            </div>
        </div>

        <!-- Email -->
        <div class="space-y-1.5 mt-5">
            <label for="email" class="block text-sm font-semibold text-[#EDEDEC]">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="block w-full pl-11 pr-4 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm" 
                    placeholder="Contoh: john@example.com">
            </div>
        </div>

        <!-- Password & No HP -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
            <div class="space-y-1.5">
                <label for="password" class="block text-sm font-semibold text-[#EDEDEC]">Password</label>
                <div class="relative" x-data="{ show: false }">
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
            
            <div class="space-y-1.5">
                <label for="no_hp" class="block text-sm font-semibold text-[#EDEDEC]">No. WhatsApp</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required
                        class="block w-full pl-11 pr-4 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm" 
                        placeholder="0812...">
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="space-y-1.5 mt-5">
            <label for="alamat" class="block text-sm font-semibold text-[#EDEDEC]">Alamat Lengkap</label>
            <textarea id="alamat" name="alamat" required rows="2"
                class="block w-full px-4 py-3 bg-[#1f1f1e] border border-[#3E3E3A] rounded-xl text-[#EDEDEC] text-sm focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all shadow-sm resize-none" 
                placeholder="Jl. Merdeka No. 123, Kota..."></textarea>
        </div>

        <!-- Mitra Specific Fields -->
        <div x-show="role === 'Mitra'" x-transition 
             class="space-y-5 mt-5 p-4 bg-[#1f1f1e] border border-primary-500/30 rounded-xl"
             style="display: none;">
             
             <div class="flex items-center gap-2 text-primary-400 mb-1">
                 <i data-lucide="info" class="w-4 h-4"></i>
                 <span class="text-xs font-bold uppercase tracking-wider">Dokumen Wajib Mitra</span>
             </div>

            <div class="space-y-1.5">
                <label for="file_skck" class="block text-sm font-semibold text-[#EDEDEC]">Upload SKCK <span class="text-red-500">*</span></label>
                <input type="file" id="file_skck" name="file_skck" accept=".pdf,.jpg,.jpeg,.png"
                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/20 file:text-primary-400 hover:file:bg-primary-500/30 transition-all border border-[#3E3E3A] bg-[#161615] rounded-xl p-1 shadow-sm" 
                    :required="role === 'Mitra'">
                <p class="text-[11px] text-gray-500 mt-1">Format: PDF/JPG max 2MB.</p>
            </div>

            <div class="space-y-1.5">
                <label for="file_sertifikat" class="block text-sm font-semibold text-[#EDEDEC]">Sertifikat Keahlian <span class="text-red-500">*</span></label>
                <input type="file" id="file_sertifikat" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png"
                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/20 file:text-primary-400 hover:file:bg-primary-500/30 transition-all border border-[#3E3E3A] bg-[#161615] rounded-xl p-1 shadow-sm" 
                    :required="role === 'Mitra'">
            </div>
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary-500/20 transition-all active:scale-[0.98] mt-2">
        <i data-lucide="user-plus" class="w-5 h-5"></i>
        Daftar Akun
    </button>
</form>

<!-- Login Link -->
<div class="mt-8 text-center text-sm text-gray-400">
    Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-primary-500 hover:text-primary-400 transition-colors">Masuk di sini</a>
</div>

@endsection
