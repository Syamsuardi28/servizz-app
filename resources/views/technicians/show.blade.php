{{-- Lokasi: resources/views/technicians/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Mitra — ' . ($tech['nama'] ?? ''))
@section('breadcrumb', 'Mitra / Teknisi / ' . ($tech['nama'] ?? ''))

@section('content')
@php
    $st = $tech['status_verifikasi'] ?? 'Pending';
    $initials = strtoupper(substr($tech['nama'] ?? 'M', 0, 1));
@endphp

<div class="mb-6">
    <a href="{{ route('technicians.index') }}" class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-[#EDEDEC] font-semibold text-sm transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Mitra
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- LEFT COLUMN: Sidebar Profile --}}
    <div class="lg:col-span-1 space-y-6">
        <x-card class="p-6">
            {{-- Avatar & Name --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-500 flex items-center justify-center text-3xl font-bold mb-4 shadow-inner overflow-hidden border-4 border-white dark:border-[#161615]">
                    @if(empty($tech['foto_profil']))
                        {{ $initials }}
                    @else
                        <img src="{{ $tech['foto_profil'] }}" alt="Profile" class="w-full h-full object-cover">
                    @endif
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $tech['nama'] ?? '—' }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">ID Mitra: {{ $tech['id_tech'] ?? '-' }}</p>
                
                @if($st === 'Terverifikasi')
                    <x-badge variant="success" class="mb-2">Terverifikasi</x-badge>
                @elseif($st === 'Pending')
                    <x-badge variant="warning" class="mb-2">Pending</x-badge>
                @else
                    <x-badge variant="danger" class="mb-2">Ditolak</x-badge>
                @endif
            </div>

            <hr class="my-6 border-gray-100 dark:border-[#3E3E3A]">

            {{-- Section: KEAHLIAN & PENGALAMAN --}}
            <div class="space-y-4">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Keahlian Utama</h3>
                    <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ $tech['keahlian'] ?? 'Umum' }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Pengalaman</h3>
                    <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">{{ $tech['pengalaman_tahun'] ?? '0' }} Tahun</p>
                </div>
            </div>

            <hr class="my-6 border-gray-100 dark:border-[#3E3E3A]">

            {{-- Section: KONTAK --}}
            <div class="space-y-4">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Alamat Domisili</h3>
                    <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $tech['alamat'] ?? '—' }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">No HP / WhatsApp</h3>
                    <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $tech['no_hp'] ?? '—' }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Email</h3>
                    <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $tech['email'] ?? '—' }}</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-[#3E3E3A]" x-data="{ openStatus: false }">
                @if(session('servizz_user.role') === 'Admin')
                    <button @click="openStatus = !openStatus" class="w-full flex items-center justify-center gap-2 py-2 px-4 bg-gray-50 dark:bg-[#262625] hover:bg-gray-100 dark:hover:bg-[#3E3E3A] border border-gray-200 dark:border-[#3E3E3A] text-gray-700 dark:text-[#EDEDEC] text-sm font-bold rounded-xl transition-colors">
                        UBAH STATUS MITRA
                    </button>
                    <div x-show="openStatus" x-transition class="mt-4 p-4 bg-gray-50 dark:bg-[#1f1f1e] rounded-xl border border-gray-200 dark:border-[#3E3E3A]" style="display: none;">
                        <form method="POST" action="{{ route('technicians.verify', $tech['id_tech']) }}">
                            @csrf
                            <select name="status" class="block w-full px-3 py-2 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-lg text-sm text-gray-700 dark:text-[#EDEDEC] mb-3 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                                <option value="Terverifikasi" {{ $st==='Terverifikasi'?'selected':'' }}>Terverifikasi</option>
                                <option value="Pending" {{ $st==='Pending'?'selected':'' }}>Pending</option>
                                <option value="Ditolak" {{ $st==='Ditolak'?'selected':'' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="w-full flex justify-center py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-bold rounded-lg transition-colors">SIMPAN STATUS</button>
                        </form>
                    </div>
                @else
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $tech['no_hp'] ?? '') }}" target="_blank" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-green-500/30">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> HUBUNGI WHATSAPP
                    </a>
                @endif
            </div>
        </x-card>
    </div>

    {{-- RIGHT COLUMN: Tabs & Content --}}
    <div class="lg:col-span-2 space-y-6" x-data="{ tab: 'stats' }">
        
        {{-- Tabs Header --}}
        <div class="flex gap-2 p-1 bg-gray-100 dark:bg-[#1f1f1e] rounded-xl border border-gray-200 dark:border-[#3E3E3A] w-fit">
            <button @click="tab = 'stats'" :class="{ 'bg-white dark:bg-[#262625] text-gray-900 dark:text-[#EDEDEC] shadow-sm': tab === 'stats', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300': tab !== 'stats' }" class="px-4 py-2 text-sm font-bold rounded-lg transition-all">Statistik & Ulasan</button>
            <button @click="tab = 'docs'" :class="{ 'bg-white dark:bg-[#262625] text-gray-900 dark:text-[#EDEDEC] shadow-sm': tab === 'docs', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300': tab !== 'docs' }" class="px-4 py-2 text-sm font-bold rounded-lg transition-all">Dokumen Persyaratan</button>
        </div>

        {{-- Tab Content 1: Academic Stats (Ulasan & Rating) --}}
        <div x-show="tab === 'stats'" x-transition>
            <x-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC]">Statistik Kinerja Teknisi</h2>
                </x-slot>
                
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-1">RINGKASAN RATING</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Berikut adalah rekapitulasi nilai ulasan yang diberikan oleh pelanggan setelah pesanan diselesaikan.</p>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-[#1f1f1e] border border-gray-100 dark:border-[#3E3E3A] rounded-xl text-center">
                            <div class="text-2xl font-black text-amber-500 mb-1 flex items-center justify-center gap-1"><i data-lucide="star" class="w-5 h-5 fill-amber-500"></i> {{ number_format($ratingData['rata_rata'] ?? 0, 2) }}</div>
                            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Rating Rata-rata</div>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-[#1f1f1e] border border-gray-100 dark:border-[#3E3E3A] rounded-xl text-center">
                            <div class="text-2xl font-black text-gray-900 dark:text-[#EDEDEC] mb-1">{{ $ratingData['total_rating'] ?? 0 }}</div>
                            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total Ulasan</div>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-[#1f1f1e] border border-gray-100 dark:border-[#3E3E3A] rounded-xl text-center">
                            <div class="text-2xl font-black text-primary-500 mb-1">{{ $tech['total_order_selesai'] ?? 0 }}</div>
                            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Order Selesai</div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-4">RIWAYAT ULASAN</h3>
                    @if(!empty($ratingData['ratings']) && count($ratingData['ratings']))
                        <div class="space-y-4">
                            @foreach($ratingData['ratings'] as $r)
                            <div class="p-4 border border-gray-100 dark:border-[#3E3E3A] rounded-xl hover:bg-gray-50 dark:hover:bg-[#1f1f1e] transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <strong class="text-sm text-gray-900 dark:text-[#EDEDEC]">{{ $r['nama_pelanggan'] }}</strong>
                                    <div class="flex text-amber-500">
                                        @for($i=1; $i<=5; $i++)
                                            <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $r['nilai'] ? 'fill-amber-500' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2 italic">"{{ $r['komentar'] ?? 'Tidak ada komentar.' }}"</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ date('d M Y H:i', strtotime($r['created_at'])) }}</div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 dark:bg-[#1f1f1e] rounded-xl border border-dashed border-gray-200 dark:border-[#3E3E3A]">
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada ulasan pelanggan.</p>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>

        {{-- Tab Content 2: Program Requirements (Dokumen Verifikasi) --}}
        <div x-show="tab === 'docs'" style="display: none;" x-transition>
            <x-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC]">Dokumen Verifikasi Mitra</h2>
                </x-slot>
                
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-1">SYARAT PENDAFTARAN WAJIB</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Berikut adalah dokumen yang diperlukan untuk memverifikasi pendaftaran sebagai Mitra Servizz. Klik tombol untuk mengunduh atau melihat file.</p>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">File Surat Keterangan Catatan Kepolisian (SKCK):</p>
                            @if(!empty($tech['foto_skck']))
                                <a href="{{ $tech['foto_skck'] }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800/50 rounded-lg text-sm font-bold hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors">
                                    <i data-lucide="file-check" class="w-4 h-4"></i> Lihat SKCK
                                </a>
                            @else
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-[#262625] text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-[#3E3E3A] rounded-lg text-sm font-bold">
                                    <i data-lucide="file-x" class="w-4 h-4"></i> SKCK (Kosong)
                                </div>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">File Sertifikat Keahlian / Kompetensi Teknis:</p>
                            @if(!empty($tech['sertifikat_url']))
                                <a href="{{ $tech['sertifikat_url'] }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800/50 rounded-lg text-sm font-bold hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors">
                                    <i data-lucide="file-check" class="w-4 h-4"></i> Lihat Sertifikat
                                </a>
                            @else
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-[#262625] text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-[#3E3E3A] rounded-lg text-sm font-bold">
                                    <i data-lucide="file-x" class="w-4 h-4"></i> Sertifikat (Kosong)
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="my-6 border-gray-100 dark:border-[#3E3E3A]">

                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-1">PERSYARATAN TAMBAHAN LAINNYA</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Dokumen pendukung lainnya (Opsional).</p>
                    
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">1.0 File Identitas atau Portofolio:</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-[#1f1f1e] text-gray-400 border border-dashed border-gray-200 dark:border-[#3E3E3A] rounded-lg text-sm font-bold">
                        BELUM TERSEDIA
                    </div>
                </div>
            </x-card>
        </div>

    </div>
</div>

@endsection