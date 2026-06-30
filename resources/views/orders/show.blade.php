{{-- Lokasi: resources/views/orders/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Pesanan #' . ($order['id_order'] ?? ''))
@section('breadcrumb', 'Pesanan / Detail #' . ($order['id_order'] ?? ''))

@section('content')
@php
$badgeMap = [
    'Menunggu'=>'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
    'Dikonfirmasi'=>'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-500',
    'Teknisi Berangkat'=>'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-500',
    'Sedang Dikerjakan'=>'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-500',
    'Selesai'=>'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500',
    'Dibatalkan'=>'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500',
    'Disetujui'=>'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500',
    'Menunggu Persetujuan'=>'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
    'Ditolak'=>'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500',
];
$stages = ['Menunggu', 'Dikonfirmasi', 'Teknisi Berangkat', 'Sedang Dikerjakan', 'Selesai'];
$currentStageIndex = array_search($order['status_order'], $stages);
if($currentStageIndex === false) $currentStageIndex = -1;
@endphp

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
    /* Custom Scrollbar for right col if needed */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="flex flex-col gap-6">
    {{-- ── Header ── --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
            <i class="bi bi-arrow-left"></i>
            <span class="font-semibold text-lg">Detail Pesanan</span>
        </a>
        
        @if(in_array(session('servizz_user.role'), ['Admin', 'Mitra']) && !in_array($order['status_order'], ['Selesai', 'Dibatalkan']))
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-[#20201f] transition-colors shadow-sm">
                    Update Status <i class="bi bi-chevron-down text-xs"></i>
                </button>
                <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-64 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl shadow-lg p-4 z-50">
                    <form method="POST" action="{{ route('orders.status', $order['id_order']) }}" class="m-0">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ubah Status Menjadi:</label>
                        <select name="status" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white mb-3">
                            @foreach(['Dikonfirmasi','Teknisi Berangkat','Sedang Dikerjakan','Selesai','Dibatalkan'] as $s)
                            <option value="{{ $s }}" {{ $order['status_order']===$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-primary text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-primary/90 transition-colors">Simpan Status</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    {{-- ── Container ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- ── Left Column Card ── --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_pelanggan']) }}&background=random" class="w-14 h-14 rounded-full border-2 border-white dark:border-[#161615] shadow-sm" alt="Avatar">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $order['nama_pelanggan'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pelanggan</p>
                        @if($order['status_order'] === 'Selesai' && !empty($order['rating_nilai']))
                            <div class="flex items-center gap-1 text-sm text-yellow-500 font-medium mt-1">
                                <i class="bi bi-star-fill"></i> {{ number_format($order['rating_nilai'], 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1 flex justify-between">
                        <span>Layanan Dipesan</span>
                        <span class="text-primary normal-case">{{ \Carbon\Carbon::parse($order['tgl_kunjungan'])->diffForHumans() }}</span>
                    </div>
                    <div class="font-semibold text-gray-900 dark:text-white text-base mb-1">{{ $order['nama_service'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">ID Pesanan #{{ $order['id_order'] }}</div>
                </div>

                <hr class="border-gray-100 dark:border-[#3E3E3A] mb-6">

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Stage</span>
                        <span class="text-sm font-semibold text-primary flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            {{ $order['status_order'] }}
                        </span>
                    </div>
                    <div class="flex gap-1 h-2">
                        @foreach($stages as $index => $stage)
                            <div class="flex-1 rounded-full {{ $index <= $currentStageIndex ? 'bg-primary' : 'bg-gray-100 dark:bg-[#20201f]' }}"></div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    @if($order['status_order'] === 'Menunggu' && empty($order['id_tech']) && session('servizz_user.role') === 'Admin')
                        <button onclick="document.getElementById('assignForm').scrollIntoView({behavior:'smooth'});" class="w-full bg-primary text-white rounded-xl px-4 py-3 font-medium hover:bg-primary/90 transition-colors shadow-sm shadow-primary/30 flex justify-center items-center gap-2">
                            <i class="bi bi-person-fill-add"></i> Tugaskan Teknisi
                        </button>
                    @elseif(session('servizz_user.role') === 'Pelanggan' && in_array($order['status_order'], ['Menunggu', 'Dikonfirmasi']))
                        <form method="POST" action="{{ route('orders.pay', $order['id_order']) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-[#002e5f] text-white rounded-xl px-4 py-3 font-medium hover:bg-[#002e5f]/90 transition-colors shadow-sm flex justify-center items-center gap-2">
                                <i class="bi bi-credit-card-fill"></i> Bayar Midtrans
                            </button>
                        </form>
                    @else
                        <div class="w-full bg-gray-50 dark:bg-[#20201f] text-gray-400 dark:text-gray-500 rounded-xl px-4 py-3 font-medium text-center border border-gray-100 dark:border-[#3E3E3A]">
                            {{ $order['status_order'] }}
                        </div>
                    @endif
                </div>

                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Contact Info</h3>
                
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Phone Number</div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ $order['hp_pelanggan'] }}</div>
                    </div>
                </div>
                
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-rose-50 dark:bg-rose-900/20 text-rose-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Address</div>
                        <div class="font-medium text-gray-900 dark:text-white leading-snug">{{ $order['alamat_pelanggan'] ?? '—' }}</div>
                    </div>
                </div>

                @if(!empty($order['latitude']) && !empty($order['longitude']))
                <div class="flex items-start gap-4 mb-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-map"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Location</div>
                        <a href="https://maps.google.com/?q={{ $order['latitude'] }},{{ $order['longitude'] }}" target="_blank" class="font-medium text-primary hover:underline">Buka di Google Maps</a>
                    </div>
                </div>
                <div class="w-full h-36 rounded-xl border border-gray-200 dark:border-[#3E3E3A] overflow-hidden z-10 relative">
                    <div id="showMap" class="w-full h-full z-10"></div>
                </div>
                @endif

            </div>
        </div>

        {{-- ── Right Column ── --}}
        <div class="lg:col-span-2 flex flex-col">
            
            {{-- Tabs --}}
            <div class="flex gap-4 border-b border-gray-200 dark:border-[#3E3E3A] mb-6 overflow-x-auto hide-scrollbar">
                <a href="#progress-section" class="pb-3 text-sm font-semibold border-b-2 border-primary text-primary whitespace-nowrap">Hiring Progress</a>
                @if(session('servizz_user.role') === 'Mitra' || !empty($order['id_nego']))
                    <a href="#notes-section" class="pb-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap">Diagnosa & Biaya</a>
                @endif
                @if(count($evidence))
                    <a href="#evidence-section" class="pb-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap">Bukti Kerja</a>
                @endif
            </div>

            <div class="flex-1 space-y-6">
                
                {{-- Stage Header --}}
                <div class="flex justify-between items-end">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Current Stage</h2>
                    @if(session('servizz_user.role') === 'Pelanggan' && $order['status_order'] === 'Selesai')
                        <button onclick="document.getElementById('rating-section').scrollIntoView({behavior:'smooth'});" class="flex items-center gap-2 text-sm font-medium text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 px-3 py-1.5 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/40 transition-colors">
                            Give Rating <i class="bi bi-chevron-down"></i>
                        </button>
                    @endif
                </div>

                {{-- Big Tracker --}}
                <div class="flex overflow-hidden rounded-xl border border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
                    @foreach($stages as $index => $stage)
                        @php
                            $bgClass = 'bg-white dark:bg-[#161615]';
                            $textClass = 'text-gray-400 dark:text-gray-500';
                            if($index < $currentStageIndex) {
                                $bgClass = 'bg-primary/10 dark:bg-primary/20';
                                $textClass = 'text-primary font-medium';
                            } elseif($index === $currentStageIndex) {
                                $bgClass = 'bg-primary';
                                $textClass = 'text-white font-semibold shadow-inner';
                            }
                        @endphp
                        <div class="flex-1 py-3 px-2 text-center text-xs md:text-sm border-r border-gray-100 dark:border-[#3E3E3A] last:border-r-0 {{ $bgClass }} {{ $textClass }} transition-colors">
                            {{ $stage }}
                        </div>
                    @endforeach
                </div>

                {{-- Info Grid --}}
                <h3 class="font-bold text-gray-900 dark:text-white mt-8 mb-4">Stage Info</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-100 dark:border-[#3E3E3A]">
                        <h4 class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jadwal Kunjungan</h4>
                        <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($order['tgl_kunjungan'])->locale('id')->isoFormat('D MMM Y, HH:mm') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-100 dark:border-[#3E3E3A]">
                        <h4 class="text-xs text-gray-500 dark:text-gray-400 mb-2">Status Pesanan</h4>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md {{ $badgeMap[$order['status_order']] ?? 'bg-gray-100 text-gray-800' }}">{{ $order['status_order'] }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-100 dark:border-[#3E3E3A]">
                        <h4 class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Biaya</h4>
                        @php $totalBiaya = (!empty($order['id_nego'])) ? ($order['total_biaya']??0) : ($order['biaya_kunjungan']??0); @endphp
                        <p class="font-bold text-lg text-primary">Rp {{ number_format($totalBiaya,0,',','.') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-100 dark:border-[#3E3E3A]">
                        <h4 class="text-xs text-gray-500 dark:text-gray-400 mb-2">Assigned To</h4>
                        <div class="flex -space-x-2 overflow-hidden">
                            @if($order['nama_mitra'])
                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-[#20201f]" src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra']) }}&background=random" title="Teknisi: {{ $order['nama_mitra'] }}">
                            @endif
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-[#20201f]" src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_pelanggan']) }}&background=random" title="Pelanggan: {{ $order['nama_pelanggan'] }}">
                        </div>
                    </div>
                </div>

                {{-- Hiring Progress Timeline --}}
                <h3 id="progress-section" class="font-bold text-gray-900 dark:text-white mt-8 mb-4">Riwayat Progres</h3>
                <div class="bg-white dark:bg-[#161615] rounded-2xl p-6 border border-gray-100 dark:border-[#3E3E3A]">
                    @if($progress->isEmpty())
                        <div class="text-center py-6 text-sm text-gray-500 dark:text-gray-400">Belum ada pembaruan status.</div>
                    @else
                        <ol class="relative border-l border-gray-200 dark:border-[#3E3E3A] ml-3">                  
                            @foreach($progress as $idx => $prog)
                                <li class="mb-6 ml-6 {{ $idx === count($progress) - 1 ? 'mb-0' : '' }}">            
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-primary-100 rounded-full -left-3 ring-4 ring-white dark:ring-[#161615] dark:bg-primary-900/30">
                                        <i class="bi bi-check-circle-fill text-primary text-xs"></i>
                                    </span>
                                    <h4 class="flex items-center mb-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $prog->status }}</h4>
                                    <time class="block mb-2 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($prog->created_at)->locale('id')->isoFormat('D MMM Y, HH:mm') }}</time>
                                    <p class="mb-2 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $prog->description }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>

                {{-- Admin Status Update Panel (Alternative to top dropdown) --}}
                @if(in_array(session('servizz_user.role'), ['Admin', 'Mitra']) && !in_array($order['status_order'], ['Selesai', 'Dibatalkan']))
                    <div x-data="{ showStatusForm: false }" class="mt-6">
                        <button x-show="!showStatusForm" @click="showStatusForm = true" class="w-full bg-white dark:bg-[#161615] border-2 border-dashed border-gray-300 dark:border-[#3E3E3A] text-gray-500 dark:text-gray-400 hover:text-primary hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 rounded-xl px-4 py-3 font-medium transition-all text-sm flex justify-center items-center gap-2">
                            Move To Next Step <i class="bi bi-arrow-right"></i>
                        </button>
                        
                        <div x-show="showStatusForm" style="display:none;" class="bg-blue-50 dark:bg-blue-900/10 rounded-xl p-5 border border-blue-100 dark:border-blue-900/30">
                            <form method="POST" action="{{ route('orders.status', $order['id_order']) }}" class="m-0">
                                @csrf
                                <label class="block text-sm font-semibold text-blue-900 dark:text-blue-300 mb-3">Update Status Pesanan</label>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <select name="status" class="flex-1 bg-white border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#161615] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white">
                                        @foreach(['Dikonfirmasi','Teknisi Berangkat','Sedang Dikerjakan','Selesai','Dibatalkan'] as $s)
                                        <option value="{{ $s }}" {{ $order['status_order']===$s?'selected':'' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white rounded-lg px-6 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors shrink-0">Simpan Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Assign Form --}}
                @if(session('servizz_user.role') === 'Admin' && empty($order['nama_mitra']))
                    <div id="assignForm" class="mt-8 bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-blue-200 dark:border-blue-900/50 p-6 overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                                <i class="bi bi-person-fill-add text-lg"></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Tugaskan Teknisi</h3>
                        </div>
                        <form method="POST" action="{{ route('orders.assign', $order['id_order']) }}">
                            @csrf
                            <select name="id_tech" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white mb-4" required>
                                <option value="">— pilih teknisi —</option>
                                @foreach($techs as $t)
                                <option value="{{ $t['id_tech'] }}">{{ $t['nama'] }} (⭐{{ number_format($t['rating_rata2'],1) }})</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-medium hover:bg-blue-700 transition-colors shadow-sm shadow-blue-500/30">Tugaskan Sekarang</button>
                        </form>
                    </div>
                @endif

                {{-- Notes Section (Diagnosa, Negosiasi) --}}
                <div id="notes-section" class="flex justify-between items-end mt-10 mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Notes</h3>
                </div>

                {{-- Input Diagnosa Mitra --}}
                @if(session('servizz_user.role') === 'Mitra' && empty($order['id_nego']))
                    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
                        <form method="POST" action="{{ route('orders.nego.store', $order['id_order']) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_kerusakan" rows="3" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white" required placeholder="Jelaskan detail kerusakan hasil diagnosa..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rincian Barang / Sparepart</label>
                                <textarea name="rincian_barang" rows="2" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white" placeholder="Rincian sparepart yang diganti..."></textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga Barang (Rp) <span class="text-red-500">*</span></label>
                                    <input type="number" name="harga_barang" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white" min="0" value="0" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Biaya Jasa (Rp) <span class="text-red-500">*</span></label>
                                    <input type="number" name="biaya_jasa" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white" min="0" value="0" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white rounded-xl px-4 py-3 font-medium hover:bg-primary/90 transition-colors shadow-sm shadow-primary/30">Kirim Rincian Biaya</button>
                        </form>
                    </div>
                @endif

                {{-- Existing Note (Nego Data) --}}
                @if(!empty($order['id_nego']))
                    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra'] ?? 'Teknisi') }}&background=random" class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $order['nama_mitra'] ?? 'Teknisi' }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Teknisi</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-md {{ $badgeMap[$order['status_acc']] ?? 'bg-gray-100 text-gray-800' }}">{{ $order['status_acc'] }}</span>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-[#20201f] rounded-xl p-4 border border-gray-100 dark:border-[#3E3E3A] text-sm text-gray-700 dark:text-gray-300">
                            <div class="mb-3">
                                <strong class="text-gray-900 dark:text-white">Diagnosa:</strong> <br>
                                {{ $order['deskripsi_kerusakan'] }}
                            </div>
                            <div class="mb-4">
                                <strong class="text-gray-900 dark:text-white">Sparepart:</strong> <br>
                                {{ $order['rincian_barang'] ?? '-' }}
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-[#3E3E3A]">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs block mb-1">Harga Barang</span>
                                    <strong class="text-gray-900 dark:text-white">Rp {{ number_format($order['harga_barang']??0,0,',','.') }}</strong>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs block mb-1">Biaya Jasa</span>
                                    <strong class="text-gray-900 dark:text-white">Rp {{ number_format($order['biaya_jasa']??0,0,',','.') }}</strong>
                                </div>
                            </div>
                        </div>
                        
                        @if(session('servizz_user.role') === 'Pelanggan' && $order['status_acc'] === 'Menunggu Persetujuan')
                            <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-[#3E3E3A]">
                                <form method="POST" action="{{ route('orders.nego.decide', $order['id_order']) }}" class="flex-1 m-0">
                                    @csrf
                                    <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                                    <input type="hidden" name="is_approved" value="1">
                                    <button type="submit" class="w-full bg-emerald-500 text-white rounded-xl px-4 py-2.5 font-medium hover:bg-emerald-600 transition-colors shadow-sm shadow-emerald-500/20 flex justify-center items-center gap-2">
                                        <i class="bi bi-check-circle"></i> Setujui Biaya
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('orders.nego.decide', $order['id_order']) }}" class="flex-1 m-0">
                                    @csrf
                                    <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                                    <input type="hidden" name="is_approved" value="0">
                                    <button type="submit" class="w-full bg-white dark:bg-[#161615] text-red-500 border border-red-200 dark:border-red-900/50 rounded-xl px-4 py-2.5 font-medium hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors flex justify-center items-center gap-2">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Evidence Section --}}
                @if(session('servizz_user.role') === 'Mitra' && !empty($order['id_nego']))
                    <div id="evidence-section" class="mt-8 mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Bukti Kerja (Evidence)</h3>
                    </div>
                    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
                        <form method="POST" action="{{ route('orders.evidence.store', $order['id_order']) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Kerusakan/Perbaikan <span class="text-red-500">*</span></label>
                                    <input type="file" name="foto_kerusakan" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-2 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Nota/Struk</label>
                                    <input type="file" name="foto_nota" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-2 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan Bukti</label>
                                <input type="text" name="deskripsi" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 dark:bg-[#20201f] dark:border-[#3E3E3A] dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Pekerjaan selesai dan mesin sudah menyala">
                            </div>
                            <button type="submit" class="w-full bg-sky-500 text-white rounded-xl px-4 py-3 font-medium hover:bg-sky-600 transition-colors shadow-sm shadow-sky-500/30 flex justify-center items-center gap-2">
                                <i class="bi bi-cloud-upload"></i> Unggah Bukti
                            </button>
                        </form>
                    </div>
                @endif

                @if(count($evidence))
                    @foreach($evidence as $index => $ev)
                    <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-200 dark:border-[#3E3E3A] p-6 mb-4">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra'] ?? 'Teknisi') }}&background=random" class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        {{ $order['nama_mitra'] ?? 'Teknisi' }} 
                                        <span class="text-xs font-normal text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-[#20201f] px-2 py-0.5 rounded-full">mengunggah bukti</span>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($ev['created_at'])->locale('id')->isoFormat('D MMM Y, HH:mm') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                            {{ $ev['deskripsi'] }}
                        </div>
                        <div class="flex gap-4">
                            @if(!empty($ev['foto_kerusakan']))
                                <a href="{{ $ev['foto_kerusakan'] }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 dark:border-[#3E3E3A] hover:opacity-90 transition-opacity">
                                    <img src="{{ $ev['foto_kerusakan'] }}" class="w-24 h-24 object-cover" onerror="this.style.display='none'">
                                </a>
                            @endif
                            @if(!empty($ev['foto_nota']))
                                <a href="{{ $ev['foto_nota'] }}" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200 dark:border-[#3E3E3A] hover:opacity-90 transition-opacity">
                                    <img src="{{ $ev['foto_nota'] }}" class="w-24 h-24 object-cover" onerror="this.style.display='none'">
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif

                {{-- Rating Section --}}
                @if(session('servizz_user.role') === 'Pelanggan' && $order['status_order'] === 'Selesai')
                    <div id="rating-section" class="mt-10 mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Rating & Ulasan</h3>
                    </div>
                    
                    <div class="bg-amber-50 dark:bg-amber-900/10 rounded-2xl shadow-sm border border-amber-200 dark:border-amber-900/30 p-6 mb-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1 h-full bg-amber-400"></div>
                        
                        @if(empty($order['id_rating']))
                            <form method="POST" action="{{ route('orders.rating', $order['id_order']) }}" class="m-0">
                                @csrf
                                <div class="mb-4">
                                    <label class="block mb-2 text-sm font-semibold text-amber-900 dark:text-amber-500">Nilai (1-5 Bintang) <span class="text-red-500">*</span></label>
                                    <select name="nilai" class="w-full bg-white border border-amber-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 dark:bg-[#161615] dark:border-amber-900/50 dark:placeholder-gray-400 dark:text-white" required>
                                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                        <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                        <option value="3">⭐⭐⭐ (Cukup)</option>
                                        <option value="2">⭐⭐ (Kurang)</option>
                                        <option value="1">⭐ (Sangat Kurang)</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label class="block mb-2 text-sm font-semibold text-amber-900 dark:text-amber-500">Komentar Ulasan</label>
                                    <textarea name="komentar" rows="3" class="w-full bg-white border border-amber-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 dark:bg-[#161615] dark:border-amber-900/50 dark:placeholder-gray-400 dark:text-white" placeholder="Tulis pengalaman Anda menggunakan jasa teknisi ini..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-amber-500 text-white rounded-xl px-4 py-3 font-bold hover:bg-amber-600 transition-colors shadow-sm shadow-amber-500/30 flex justify-center items-center gap-2">
                                    <i class="bi bi-send-fill"></i> Kirim Ulasan
                                </button>
                            </form>
                        @else
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-amber-900 dark:text-amber-500">Rating Anda</h4>
                                <div class="text-lg text-amber-500">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi bi-star{{ $i <= $order['rating_nilai'] ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="italic text-amber-800 dark:text-amber-200 bg-amber-100/50 dark:bg-amber-900/20 p-4 rounded-xl border border-amber-100 dark:border-amber-900/30">
                                "{{ $order['rating_komentar'] ?: 'Tidak ada komentar ulasan.' }}"
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mapContainer = document.getElementById('showMap');
        if (mapContainer) {
            var lat = {{ $order['latitude'] ?? -6.200000 }};
            var lng = {{ $order['longitude'] ?? 106.816666 }};
            var map = L.map('showMap').setView([lat, lng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup('Lokasi Pelanggan').openPopup();
        }
    });
</script>
<!-- Include Alpine.js for dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@endsection