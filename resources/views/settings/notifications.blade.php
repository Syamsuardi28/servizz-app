@extends('settings.layout')

@section('setting_content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-6">Preferensi Notifikasi</h2>

    <div class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
        
        <div class="py-6 flex items-start justify-between gap-4">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white">Notifikasi Email</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Terima pembaruan pesanan dan penawaran langsung ke email Anda.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
            </label>
        </div>

        <div class="py-6 flex items-start justify-between gap-4">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white">Notifikasi Push Aplikasi</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Terima notifikasi instan saat aplikasi terbuka (Real-time).</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
            </label>
        </div>

        <div class="py-6 flex items-start justify-between gap-4">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white">Pembaruan Sistem</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Berita terbaru, tips penggunaan, dan pembaruan fitur dari SERVIZZ.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                <input type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
            </label>
        </div>

    </div>

    <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-900/30 flex items-start gap-3">
        <i data-lucide="info" class="w-5 h-5 text-blue-500 shrink-0 mt-0.5"></i>
        <p class="text-sm text-blue-800 dark:text-blue-300">Pengaturan notifikasi saat ini otomatis tersimpan secara lokal di peramban Anda.</p>
    </div>
</div>
@endsection
