@extends('settings.layout')

@section('setting_content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-6">Status Verifikasi Akun</h2>

    <div class="space-y-4">
        {{-- Email Verification (All Users) --}}
        <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/30 p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 relative overflow-hidden">
            <div class="absolute left-0 top-0 w-1 h-full bg-emerald-500"></div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="mail-check" class="w-6 h-6"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-white">Email Terverifikasi</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $user['email'] ?? 'Alamat email Anda telah diverifikasi.' }}</p>
            </div>
            <div class="shrink-0 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Terverifikasi
            </div>
        </div>

        {{-- Phone Number Verification --}}
        <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/30 p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 relative overflow-hidden">
            <div class="absolute left-0 top-0 w-1 h-full bg-emerald-500"></div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="phone" class="w-6 h-6"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-white">Nomor Telepon</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $user['no_hp'] ?? 'Nomor telepon terdaftar dan aktif.' }}</p>
            </div>
            <div class="shrink-0 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Terverifikasi
            </div>
        </div>

        @if(($user['role'] ?? '') === 'Mitra')
            @php
                $st = $user['status_verifikasi'] ?? 'Pending';
                
                $vStyle = [
                    'Terverifikasi' => [
                        'border' => 'border-emerald-100 dark:border-emerald-900/30',
                        'accent' => 'bg-emerald-500',
                        'iconBg' => 'bg-emerald-50 dark:bg-emerald-900/30',
                        'iconColor' => 'text-emerald-600',
                        'badgeBg' => 'bg-emerald-100 dark:bg-emerald-900/40',
                        'badgeText' => 'text-emerald-700 dark:text-emerald-400',
                        'text' => 'Terverifikasi'
                    ],
                    'Pending' => [
                        'border' => 'border-amber-100 dark:border-amber-900/30',
                        'accent' => 'bg-amber-500',
                        'iconBg' => 'bg-amber-50 dark:bg-amber-900/30',
                        'iconColor' => 'text-amber-600',
                        'badgeBg' => 'bg-amber-100 dark:bg-amber-900/40',
                        'badgeText' => 'text-amber-700 dark:text-amber-400',
                        'text' => 'Menunggu Tinjauan'
                    ],
                    'Ditolak' => [
                        'border' => 'border-red-100 dark:border-red-900/30',
                        'accent' => 'bg-red-500',
                        'iconBg' => 'bg-red-50 dark:bg-red-900/30',
                        'iconColor' => 'text-red-600',
                        'badgeBg' => 'bg-red-100 dark:bg-red-900/40',
                        'badgeText' => 'text-red-700 dark:text-red-400',
                        'text' => 'Ditolak'
                    ]
                ];
                $s = $vStyle[$st] ?? $vStyle['Pending'];
            @endphp

            {{-- Mitra specific verifications --}}
            <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border {{ $s['border'] }} p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 relative overflow-hidden">
                <div class="absolute left-0 top-0 w-1 h-full {{ $s['accent'] }}"></div>
                <div class="w-12 h-12 rounded-full {{ $s['iconBg'] }} {{ $s['iconColor'] }} flex items-center justify-center shrink-0">
                    <i data-lucide="file-check-2" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 dark:text-white">Dokumen Kemitraan (SKCK & Sertifikat)</h3>
                    @if($st === 'Terverifikasi')
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Dokumen Anda telah diverifikasi oleh tim admin.</p>
                    @elseif($st === 'Ditolak')
                        <p class="text-sm text-red-500 mt-0.5">Verifikasi ditolak. Silakan unggah dokumen yang valid kembali.</p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Tinjau dokumen Anda atau unggah yang baru jika diperlukan.</p>
                    @endif
                </div>
                <div class="shrink-0 {{ $s['badgeBg'] }} {{ $s['badgeText'] }} px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full {{ $s['accent'] }}"></div> {{ $s['text'] }}
                </div>
            </div>

            {{-- Form Unggah Dokumen --}}
            <div class="mt-8 bg-gray-50 dark:bg-[#20201f] rounded-2xl border border-gray-100 dark:border-[#3E3E3A] p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="folder-up" class="w-5 h-5 text-primary-500"></i> Kelola Dokumen Verifikasi
                </h3>
                
                <form action="{{ route('settings.verification.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- SKCK --}}
                    <div class="bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl p-5">
                        <label class="block font-bold text-gray-900 dark:text-white mb-2">File SKCK</label>
                        @if(!empty($user['foto_skck']))
                            <div class="mb-4 text-sm text-emerald-600 flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 p-2.5 rounded-lg border border-emerald-100 dark:border-emerald-900/30">
                                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                <span>SKCK sudah diunggah. <a href="{{ $user['foto_skck'] }}" target="_blank" class="font-bold underline hover:text-emerald-700">Lihat File</a></span>
                            </div>
                        @endif
                        <input type="file" name="foto_skck" accept="image/*,application/pdf" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-[#20201f] dark:file:text-primary-500">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Unggah file baru untuk memperbarui (Maks. 10MB, PDF/JPG/PNG).</p>
                    </div>

                    {{-- Sertifikat --}}
                    <div class="bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl p-5">
                        <label class="block font-bold text-gray-900 dark:text-white mb-2">Sertifikat Keahlian</label>
                        @if(!empty($user['sertifikat_url']))
                            <div class="mb-4 text-sm text-emerald-600 flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 p-2.5 rounded-lg border border-emerald-100 dark:border-emerald-900/30">
                                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                <span>Sertifikat sudah diunggah. <a href="{{ $user['sertifikat_url'] }}" target="_blank" class="font-bold underline hover:text-emerald-700">Lihat File</a></span>
                            </div>
                        @endif
                        <input type="file" name="sertifikat" accept="image/*,application/pdf" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-[#20201f] dark:file:text-primary-500">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Unggah file baru untuk memperbarui (Maks. 10MB, PDF/JPG/PNG).</p>
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit" variant="primary" icon="upload">Unggah Dokumen</x-button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
