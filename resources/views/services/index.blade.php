@extends('layouts.app')
@section('title', 'Kategori Jasa')
@section('breadcrumb', 'Kategori Jasa')

@section('content')

@php
    $totalServices = count($services);
    $allServices = $services;
    // Extra safety: ensure these are always arrays of arrays
    if (!is_array($allOrders)) { $allOrders = []; }
    if (!is_array($allTechs)) { $allTechs = []; }
    $allOrders = array_values(array_filter($allOrders, fn($o) => is_array($o)));
    $allTechs  = array_values(array_filter($allTechs,  fn($t) => is_array($t)));
@endphp

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Kategori Jasa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jelajahi dan temukan layanan yang Anda butuhkan.</p>
    </div>
    <div class="flex items-center gap-3 w-full sm:w-auto">
        
        <div class="relative flex-1 sm:flex-none">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500"></i>
            <input type="text" id="classSearchInput" placeholder="Cari kategori..." class="w-full sm:w-64 pl-9 pr-4 py-2.5 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 shadow-sm transition-shadow text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400">
        </div>

        @if(session('servizz_user.role') === 'Admin')
            <button x-data @click="$dispatch('open-modal', 'modalAdd')" class="flex items-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-sm shadow-primary-500/20 focus:outline-none focus:ring-2 focus:ring-primary-500/50">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
            </button>
        @endif
    </div>
</div>

<!-- Kanban Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($services as $index => $s)
        @php
            $colors = [
                ['base' => 'bg-blue-500', 'text' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-50 dark:bg-blue-500/10', 'border' => 'border-blue-200 dark:border-blue-500/20'],
                ['base' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'border' => 'border-emerald-200 dark:border-emerald-500/20'],
                ['base' => 'bg-amber-500', 'text' => 'text-amber-600 dark:text-amber-400', 'bg' => 'bg-amber-50 dark:bg-amber-500/10', 'border' => 'border-amber-200 dark:border-amber-500/20'],
                ['base' => 'bg-purple-500', 'text' => 'text-purple-600 dark:text-purple-400', 'bg' => 'bg-purple-50 dark:bg-purple-500/10', 'border' => 'border-purple-200 dark:border-purple-500/20'],
                ['base' => 'bg-rose-500', 'text' => 'text-rose-600 dark:text-rose-400', 'bg' => 'bg-rose-50 dark:bg-rose-500/10', 'border' => 'border-rose-200 dark:border-rose-500/20'],
            ];
            $c = $colors[$index % count($colors)];

            $svcId = $s['id_service'] ?? 0;
            $svcOrders = array_values(array_filter($allOrders, function($o) use ($svcId, $s) {
                if (!is_array($o)) return false;
                return ($o['service_id'] ?? 0) == $svcId || ($o['nama_service'] ?? '') == ($s['nama_service'] ?? '');
            }));
            $progSelesai = 0;
            foreach($svcOrders as $so) {
                if (is_array($so) && ($so['status_order'] ?? '') == 'Selesai') $progSelesai++;
            }
            $totalSvcOrders = count($svcOrders);
            $progMax = $totalSvcOrders > 0 ? $totalSvcOrders : 10;
            $progVal = $totalSvcOrders > 0 ? $progSelesai : 0;
            $progPct = $progMax > 0 ? ($progVal / $progMax) * 100 : 0;

            $svcTechs = array_values(array_filter($allTechs, function($t) use ($s) {
                if (!is_array($t)) return false;
                $k = strtolower((string)($t['keahlian'] ?? ''));
                $ns = strtolower((string)($s['nama_service'] ?? ''));
                return $k && $ns && (str_contains($k, $ns) || str_contains($ns, $k));
            }));
            if (empty($svcTechs)) $svcTechs = $allTechs;
        @endphp
        
        <div class="class-card-item bg-white dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] flex flex-col p-6 h-full transition-all duration-300 hover:shadow-md hover:border-primary-200 dark:hover:border-primary-500/30">
            <div class="mb-5 flex justify-between items-start gap-2">
                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold border {{ $c['bg'] }} {{ $c['text'] }} {{ $c['border'] }}">
                    {{ \Illuminate\Support\Str::limit($s['kategori'] ?? 'Layanan', 15) }}
                </span>
                
                @if(session('servizz_user.role') !== 'Pelanggan')
                    @if($s['is_active'] ?? 1)
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-full flex items-center gap-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Aktif
                        </span>
                    @else
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-500/10 border border-gray-200 dark:border-[#3E3E3A] rounded-full flex items-center gap-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div> Nonaktif
                        </span>
                    @endif
                @endif
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-2 leading-tight">{{ $s['nama_service'] }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-6 flex-1">{{ $s['deskripsi'] ?: 'Menyediakan layanan perbaikan dan perawatan profesional terbaik.' }}</p>
            
            <!-- Progress -->
            <div class="mb-6 p-3.5 bg-gray-50/50 dark:bg-[#1f1f1e] rounded-xl border border-gray-100/50 dark:border-[#3E3E3A]/50">
                <div class="flex justify-between items-center text-xs font-semibold mb-2">
                    <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5"><i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Penyelesaian</span>
                    <span class="text-gray-900 dark:text-[#EDEDEC] bg-white dark:bg-[#262625] px-1.5 py-0.5 rounded shadow-sm border border-gray-100 dark:border-[#3E3E3A]">{{ $progVal }}/{{ $progMax }}</span>
                </div>
                <div class="w-full bg-gray-200/50 dark:bg-[#262625] rounded-full h-1.5 overflow-hidden">
                    <div class="{{ $c['base'] }} h-1.5 rounded-full relative transition-all duration-500" style="width: {{ $progPct }}%"></div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-[#3E3E3A] mt-auto">
                <div class="flex items-center gap-2">
                    <div class="flex -space-x-2">
                        @foreach(array_slice($svcTechs, 0, 3) as $idx => $t)
                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-[#161615] bg-gray-100 dark:bg-[#262625] text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold shadow-sm relative z-[{{ 10 - $idx }}]" title="{{ $t['nama'] }}">
                                {{ strtoupper(substr($t['nama'] ?? 'M', 0, 1)) }}
                            </div>
                        @endforeach
                        @if(count($svcTechs) > 3)
                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-[#161615] bg-gray-50 dark:bg-[#1f1f1e] text-gray-500 dark:text-gray-400 flex items-center justify-center text-[10px] font-bold shadow-sm relative z-0">
                                +{{ count($svcTechs) - 3 }}
                            </div>
                        @endif
                    </div>
                </div>
                
                @if(session('servizz_user.role') === 'Pelanggan')
                    <button class="flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-sm shadow-primary-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-primary-500/50" 
                            x-data 
                            @click="$dispatch('open-modal', 'modalOrder'); document.getElementById('order_service_id').value = '{{ $s['id_service'] }}'; document.getElementById('order_service_name').value = '{{ $s['nama_service'] }}';">
                        <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> Pesan
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] border-dashed rounded-3xl">
            <div class="w-16 h-16 bg-gray-50 dark:bg-[#1f1f1e] text-gray-400 dark:text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="tag" class="w-8 h-8"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Belum ada kategori jasa</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Kategori yang ditambahkan akan muncul di sini.</p>
        </div>
    @endforelse
</div>

{{-- Add Modal (Admin) --}}
@if(session('servizz_user.role') === 'Admin')
<x-modal id="modalAdd" title="Tambah Kategori Jasa">
    <form method="POST" action="{{ route('services.store') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-1.5 font-heading">Nama Layanan <span class="text-red-500">*</span></label>
            <x-input name="nama_service" value="{{ old('nama_service') }}" placeholder="Contoh: Perbaikan AC..." required icon="tag" />
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-1.5 font-heading">Deskripsi Layanan</label>
            <textarea name="deskripsi" rows="3" class="w-full rounded-xl border border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 px-4 py-3 text-sm transition-all resize-none" placeholder="Jelaskan secara singkat...">{{ old('deskripsi') }}</textarea>
        </div>

        <div x-data="{ status: '1' }">
            <label class="block text-sm font-bold text-gray-900 dark:text-[#EDEDEC] mb-2 font-heading">Status Layanan</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                       :class="status == '1' ? 'border-primary-500 bg-primary-50 dark:bg-primary-500/10 shadow-sm shadow-primary-500/20' : 'border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#161615] hover:border-primary-300 dark:hover:border-primary-500/50 hover:bg-gray-50 dark:hover:bg-[#1f1f1e]'">
                    <input type="radio" name="status" value="1" x-model="status" class="sr-only">
                    <span class="text-sm font-bold flex items-center gap-2 mb-1" :class="status == '1' ? 'text-primary-700 dark:text-primary-400' : 'text-gray-900 dark:text-[#EDEDEC]'">
                        <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                              :class="status == '1' ? 'border-primary-500 bg-primary-500' : 'border-gray-300 dark:border-gray-600'">
                            <span class="w-1.5 h-1.5 bg-white rounded-full transition-transform scale-0" :class="status == '1' ? 'scale-100' : ''"></span>
                        </span>
                        Aktif
                    </span>
                    <span class="text-xs pl-6" :class="status == '1' ? 'text-primary-600 dark:text-primary-400/80' : 'text-gray-500 dark:text-gray-400'">Akan tampil di aplikasi pelanggan</span>
                </label>
                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                       :class="status == '0' ? 'border-gray-500 bg-gray-50 dark:bg-[#262625] shadow-sm' : 'border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#161615] hover:border-gray-300 dark:hover:border-[#3E3E3A] hover:bg-gray-50 dark:hover:bg-[#1f1f1e]'">
                    <input type="radio" name="status" value="0" x-model="status" class="sr-only">
                    <span class="text-sm font-bold flex items-center gap-2 mb-1" :class="status == '0' ? 'text-gray-900 dark:text-[#EDEDEC]' : 'text-gray-900 dark:text-[#EDEDEC]'">
                        <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                              :class="status == '0' ? 'border-gray-500 bg-gray-500 dark:border-gray-400 dark:bg-gray-400' : 'border-gray-300 dark:border-gray-600'">
                            <span class="w-1.5 h-1.5 bg-white dark:bg-[#161615] rounded-full transition-transform scale-0" :class="status == '0' ? 'scale-100' : ''"></span>
                        </span>
                        Nonaktif
                    </span>
                    <span class="text-xs pl-6 text-gray-500 dark:text-gray-400">Disembunyikan dari pelanggan</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 dark:border-[#3E3E3A] flex justify-end gap-3">
            <button type="button" @click="show = false" class="px-5 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl hover:bg-gray-50 dark:hover:bg-[#1f1f1e] transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-[#3E3E3A]">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-sm shadow-primary-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-primary-500/50">Simpan Kategori</button>
        </div>
    </form>
</x-modal>
@endif

{{-- Order Modal (Khusus Pelanggan) --}}
@if(session('servizz_user.role') === 'Pelanggan')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<x-modal id="modalOrder" title="Pesan Layanan">
    <form method="POST" action="{{ route('orders.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="service_id" id="order_service_id">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Layanan yang Dipilih</label>
            <x-input id="order_service_name" type="text" readonly class="bg-gray-50 dark:bg-[#1f1f1e] font-bold" icon="briefcase" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal & Waktu Kunjungan <span class="text-red-500">*</span></label>
            <x-input name="tgl_kunjungan" type="datetime-local" min="{{ date('Y-m-d\TH:i') }}" required icon="calendar" />
        </div>
        
        <div x-data="{ mapInitialized: false }" @open-modal.window="if($event.detail === 'modalOrder' && !mapInitialized) { setTimeout(() => initMap(), 300); mapInitialized = true; }">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Titik Lokasi Anda <span class="text-red-500">*</span></label>
            <div id="orderMap" class="w-full h-[200px] rounded-xl border border-gray-200 dark:border-[#3E3E3A] z-0 relative overflow-hidden bg-gray-50 dark:bg-[#1f1f1e]"></div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1"><i data-lucide="info" class="w-3.5 h-3.5"></i> Geser pin untuk menyesuaikan lokasi tepat.</p>
            <input type="hidden" name="lat" id="order_lat" required>
            <input type="hidden" name="long" id="order_long" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan</label>
            <textarea name="catatan" rows="3" class="w-full rounded-xl border-gray-200 dark:border-[#3E3E3A] shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500/20 px-3 py-2 text-sm" placeholder="Contoh: AC kamar bocor..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran (Kunjungan)</label>
            <div class="relative">
                <select name="metode_pembayaran" required class="appearance-none w-full bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] text-gray-700 dark:text-gray-300 py-2.5 pl-4 pr-10 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-all">
                    <option value="Transfer Bank">Transfer Bank (Virtual Account)</option>
                    <option value="E-Wallet">E-Wallet (GoPay, OVO, Dana)</option>
                    <option value="Tunai / Cash">Tunai (Bayar di tempat)</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 flex gap-3 text-blue-800 text-xs">
            <i data-lucide="shield-check" class="w-5 h-5 shrink-0 text-blue-500"></i>
            <div>Biaya kunjungan awal tetap <strong>Rp50.000</strong>. Biaya perbaikan final disepakati setelah teknisi melakukan inspeksi di lokasi.</div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-[#3E3E3A] flex justify-end gap-3">
            <x-button type="button" variant="ghost" @click="show = false">Batal</x-button>
            <x-button type="submit" variant="primary">Pesan Sekarang</x-button>
        </div>
    </form>
</x-modal>

<script>
    function initMap() {
        const orderMap = L.map('orderMap').setView([-6.200000, 106.816666], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OSM'
        }).addTo(orderMap);

        const orderMarker = L.marker([-6.200000, 106.816666], {draggable: true}).addTo(orderMap);

        orderMarker.on('dragend', function (event) {
            const position = event.target.getLatLng();
            document.getElementById('order_lat').value = position.lat;
            document.getElementById('order_long').value = position.lng;
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                document.getElementById('order_lat').value = lat;
                document.getElementById('order_long').value = lng;
                orderMap.setView([lat, lng], 16);
                orderMarker.setLatLng([lat, lng]);
            });
        }
    }
</script>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('classSearchInput');
    if(searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchValue = e.target.value.toLowerCase();
            const cardItems = document.querySelectorAll('.class-card-item');
            cardItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if(text.includes(searchValue)) {
                    item.parentElement.style.display = '';
                } else {
                    item.parentElement.style.display = 'none';
                }
            });
        });
    }

    @if ($errors->any())
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modalAdd' }));
    @endif
});
</script>
@endsection
