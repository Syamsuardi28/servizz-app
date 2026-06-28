{{-- Lokasi: resources/views/services/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kategori Jasa')
@section('breadcrumb', 'Kategori Jasa')


@push('styles')
    @vite('resources/css/services.css')
@endpush

@section('content')

@php
    $totalServices = count($services);
    // Pisahkan 2 pertama untuk menjadi Featured Cards (Kategori Utama)
    $featuredServices = array_slice($services, 0, 2);
    $allServices = $services; // Semua kategori tetap masuk ke grid bawah agar lengkap
@endphp

<div class="class-page-wrap">

    {{-- ── Header Section ── --}}
    <div class="class-header">
        <div class="class-header-left">
            <a href="{{ route('dashboard') }}" class="class-back-btn"><i class="bi bi-arrow-left"></i></a>
            <h1 class="class-title">Kategori Jasa</h1>
        </div>
        <div class="class-header-right">
            <div class="class-search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="classSearchInput" placeholder="Cari kategori...">
            </div>
            @if(session('servizz_user.role') === 'Admin')
                <button class="class-create-btn" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </button>
            @endif
        </div>
    </div>

    {{-- ── Kanban Grid Section ── --}}
    <div class="kanban-grid">
        @forelse($services as $index => $s)
            @php
                $colors = [
                    ['bg' => '#0ea5e9', 'text' => '#ffffff'], // Cyan
                    ['bg' => '#f59e0b', 'text' => '#ffffff'], // Yellow
                    ['bg' => '#2dd4bf', 'text' => '#ffffff'], // Teal
                    ['bg' => '#a855f7', 'text' => '#ffffff'], // Purple
                    ['bg' => '#f43f5e', 'text' => '#ffffff'], // Rose
                ];
                $c = $colors[$index % count($colors)];

                // Hitung progress
                $svcId = $s['id_service'] ?? 0;
                $svcOrders = array_filter($allOrders, fn($o) => ($o['service_id'] ?? 0) == $svcId || ($o['nama_service'] ?? '') == $s['nama_service']);
                $progSelesai = 0; $progProses = 0; $progBatal = 0;
                foreach($svcOrders as $so) {
                    if (($so['status_order'] ?? '') == 'Selesai') $progSelesai++;
                    elseif (($so['status_order'] ?? '') == 'Dibatalkan') $progBatal++;
                    else $progProses++;
                }
                $totalSvcOrders = count($svcOrders);
                $progMax = $totalSvcOrders > 0 ? $totalSvcOrders : 10;
                $progVal = $totalSvcOrders > 0 ? $progSelesai : 0;
                $progPct = ($progVal / $progMax) * 100;

                // Filter mitra
                $svcTechs = array_filter($allTechs, function($t) use ($s) {
                    $k = strtolower($t['keahlian'] ?? '');
                    $ns = strtolower($s['nama_service'] ?? '');
                    return $k && $ns && (str_contains($k, $ns) || str_contains($ns, $k));
                });
                if (empty($svcTechs)) $svcTechs = $allTechs; // Fallback
            @endphp
            <div class="kb-card class-card-item">
                <div class="kb-tag" style="background: {{ $c['bg'] }}; color: {{ $c['text'] }};">
                    {{ Str::limit($s['kategori'] ?? 'Layanan', 12) }}
                </div>
                
                <h3 class="kb-title">{{ $s['nama_service'] }}</h3>
                <p class="kb-desc">{{ Str::limit($s['deskripsi'] ?: 'Menyediakan layanan perbaikan dan perawatan profesional terbaik.', 65) }}</p>
                
                <div class="kb-progress-box">
                    <div class="kb-progress-lbl">
                        <span>Progress</span>
                        <span>{{ $progVal }}/{{ $progMax }}</span>
                    </div>
                    <div class="kb-progress-bar">
                        <div class="kb-progress-fill" style="width: {{ $progPct }}%; background-color: #ef4444;">
                            <div class="kb-progress-thumb"></div>
                        </div>
                    </div>
                </div>

                <div class="kb-footer">
                    <div class="kb-date">
                        <i class="bi bi-clock" style="color:#d1d5db; margin-right:4px;"></i> 
                        <span style="color:#9ca3af;">{{ \Carbon\Carbon::parse($s['created_at'] ?? now())->format('d') }}</span>
                        <span style="color:#d1d5db; margin:0 4px;">•</span>
                        <span style="color:#9ca3af;">{{ \Carbon\Carbon::parse($s['created_at'] ?? now())->format('M') }}</span>
                    </div>
                    
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div class="kb-avatars">
                            @foreach(array_slice($svcTechs, 0, 2) as $t)
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['nama'] ?? 'M') }}&background=random" alt="Ava" class="kb-avatar-img">
                            @endforeach
                        </div>
                        
                        @if(session('servizz_user.role') === 'Pelanggan')
                            <button class="kb-priority-tag urgent" data-bs-toggle="modal" data-bs-target="#modalOrder" data-id="{{ $s['id_service'] }}" data-name="{{ $s['nama_service'] }}" style="border:none; cursor:pointer;">Pesan</button>
                        @else
                            <div class="kb-priority-tag high">{{ ($s['is_active'] ?? 1) ? 'Aktif' : 'Nonaktif' }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="class-empty-state">
                <i class="bi bi-tags-fill"></i>
                <h4>Belum ada kategori jasa</h4>
                <p>Klik tombol di atas untuk menambahkan kategori jasa baru Anda.</p>
            </div>
        @endforelse
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-wide">
            <div class="modal-content class-modal-content" style="border: none; border-radius: 16px; position: relative; overflow: hidden;">
                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" 
                        style="position: absolute; right: 20px; top: 20px; z-index: 10; filter: invert(0.5);"></button>
                
                <form method="POST" action="{{ route('services.store') }}">
                    @csrf
                    <div class="modal-body p-0">
                        <div class="svz-add-layout">
                            <!-- Left Column: Form Fields -->
                            <div class="svz-add-form-col">
                                <h3 class="svz-add-section-title"><i class="bi bi-info-circle-fill" style="color: var(--primary, #185FA5); margin-right: 8px;"></i> Informasi Kategori</h3>
                                
                                <div class="svz-add-input-group">
                                    <label class="svz-add-label" for="nama_service">Nama Layanan <span class="req">*</span></label>
                                    <input type="text" 
                                           class="svz-add-input @error('nama_service') is-invalid @enderror" 
                                           id="nama_service" 
                                           name="nama_service" 
                                           value="{{ old('nama_service') }}"
                                           placeholder="Contoh: Perbaikan AC..." 
                                           required>
                                    @error('nama_service')
                                        <div class="invalid-feedback d-block" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="svz-add-input-group" style="margin-bottom: 0;">
                                    <label class="svz-add-label" for="deskripsi">Deskripsi Layanan</label>
                                    <textarea class="svz-add-input @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="5"
                                              placeholder="Jelaskan secara singkat tentang layanan ini...">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback d-block" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column: Settings & Action -->
                            <div class="svz-add-settings-col">
                                <div>
                                    <h3 class="svz-add-section-title"><i class="bi bi-sliders" style="color: var(--primary, #185FA5); margin-right: 8px;"></i> Status Layanan</h3>
                                    
                                    <p class="svz-add-label" style="margin-bottom: 12px;">Pilih Status Kategori</p>
                                    <div class="svz-status-cards">
                                        <!-- Box 1: Aktif -->
                                        <div class="svz-status-card active" data-value="1">
                                            <div class="svz-status-icon">🟢</div>
                                            <div class="svz-status-value">Aktif</div>
                                            <div class="svz-status-desc">Kategori aktif & langsung dapat diakses</div>
                                        </div>
                                        <!-- Box 2: Nonaktif -->
                                        <div class="svz-status-card" data-value="0">
                                            <div class="svz-status-icon">🔴</div>
                                            <div class="svz-status-value">Nonaktif</div>
                                            <div class="svz-status-desc">Disembunyikan dari aplikasi pelanggan</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="status" id="status_value" value="1">
                                </div>
                                
                                <div class="svz-add-action-wrap">
                                    <button type="submit" class="svz-add-submit-btn">Simpan Kategori</button>
                                    <button type="button" class="svz-add-cancel-btn" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Order Modal (Khusus Pelanggan) --}}
    @if(session('servizz_user.role') === 'Pelanggan')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="modalOrderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-wide">
            <div class="modal-content class-modal-content" style="border: none; border-radius: 16px; position: relative; overflow: hidden; max-width: 900px;">
                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" 
                        style="position: absolute; right: 20px; top: 20px; z-index: 10; filter: invert(0.5);"></button>
                
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <input type="hidden" name="service_id" id="order_service_id">
                    <div class="modal-body p-0">
                        <div class="svz-add-layout">
                            <!-- Left Column: Form Fields -->
                            <div class="svz-add-form-col">
                                <h3 class="svz-add-section-title">
                                    <i class="bi bi-cart-fill" style="color: var(--primary, #185FA5); margin-right: 8px;"></i>
                                    Form Pemesanan Jasa
                                </h3>
                                
                                <div class="svz-add-input-group">
                                    <label class="svz-add-label">Nama Layanan</label>
                                    <input type="text" id="order_service_name" class="svz-add-input" readonly 
                                           style="background:#f1f5f9; cursor:not-allowed; border: 1.5px solid #e2e8f0; font-weight:600; color:#1e293b;">
                                </div>
                                
                                <div class="svz-add-input-group">
                                    <label class="svz-add-label">Tanggal & Waktu Kunjungan <span class="req">*</span></label>
                                    <input type="datetime-local" name="tgl_kunjungan" class="svz-add-input" required 
                                           min="{{ date('Y-m-d\TH:i') }}">
                                </div>
                                
                                <div class="svz-add-input-group">
                                    <label class="svz-add-label">Pilih Titik Lokasi Anda <span class="req">*</span></label>
                                    <div id="orderMap" style="width: 100%; height: 250px; border-radius: 12px; border: 1px solid #cbd5e1; z-index: 1;"></div>
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 6px;">
                                        <i class="bi bi-info-circle"></i> Peta akan mendeteksi lokasi Anda. Anda dapat menggeser pin merah untuk penyesuaian.
                                    </div>
                                    <input type="hidden" name="lat" id="order_lat" required>
                                    <input type="hidden" name="long" id="order_long" required>
                                </div>
                                
                                <div class="svz-add-input-group" style="margin-bottom: 0;">
                                    <label class="svz-add-label">Catatan Tambahan / Detail Kerusakan</label>
                                    <textarea name="catatan" class="svz-add-input" rows="3" 
                                              placeholder="Contoh: AC kamar bocor air, merk Panasonic..."></textarea>
                                </div>
                            </div>

                            <!-- Right Column: Settings & Action -->
                            <div class="svz-add-settings-col">
                                <div>
                                    <h3 class="svz-add-section-title">
                                        <i class="bi bi-wallet2" style="color: var(--primary, #185FA5); margin-right: 8px;"></i>
                                        Metode Pembayaran
                                    </h3>
                                    
                                    <div class="svz-add-input-group" style="margin-top: 12px;">
                                        <label class="svz-add-label">Pilih Pembayaran Kunjungan Dasar</label>
                                        <select name="metode_pembayaran" class="svz-add-input" required style="cursor: pointer;">
                                            <option value="Transfer Bank">Transfer Bank (Virtual Account)</option>
                                            <option value="E-Wallet">E-Wallet (GoPay, OVO, Dana)</option>
                                            <option value="Tunai / Cash">Tunai (Bayar di tempat)</option>
                                        </select>
                                    </div>

                                    <h3 class="svz-add-section-title" style="margin-top:24px;">
                                        <i class="bi bi-shield-check" style="color: var(--primary, #185FA5); margin-right: 8px;"></i>
                                        Keamanan & Transparansi
                                    </h3>
                                    <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-top: 10px; font-weight: 500;">
                                        Biaya kunjungan dasar adalah tetap sebesar <strong>Rp50.000</strong>. Biaya perbaikan dan penggantian suku cadang akan dinegosiasikan secara transparan setelah teknisi memeriksa kerusakan di lokasi.
                                    </p>
                                    <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px; padding: 12px; background: #eff6ff; border-radius: 10px; border: 1px solid #bfdbfe;">
                                        <i class="bi bi-geo-alt-fill" style="font-size: 20px; color: #1d4ed8;"></i>
                                        <span style="font-size: 11px; font-weight: 700; color: #1e40af;">Lokasi Anda direkam menggunakan koordinat Peta untuk kemudahan teknisi.</span>
                                    </div>
                                </div>
                                
                                <div class="svz-add-action-wrap">
                                    <button type="submit" class="svz-add-submit-btn">Pesan Sekarang</button>
                                    <button type="button" class="svz-add-cancel-btn" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalOrder = document.getElementById('modalOrder');
            let orderMap = null;
            let orderMarker = null;

            if (modalOrder) {
                modalOrder.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const serviceId = button.getAttribute('data-id');
                    const serviceName = button.getAttribute('data-name');
                    
                    document.getElementById('order_service_id').value = serviceId;
                    document.getElementById('order_service_name').value = serviceName;
                });

                modalOrder.addEventListener('shown.bs.modal', function () {
                    // Initialize Leaflet map if not already
                    if (!orderMap) {
                        orderMap = L.map('orderMap').setView([-6.200000, 106.816666], 13); // Default Jakarta
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(orderMap);

                        orderMarker = L.marker([-6.200000, 106.816666], {draggable: true}).addTo(orderMap);

                        orderMarker.on('dragend', function (event) {
                            const marker = event.target;
                            const position = marker.getLatLng();
                            document.getElementById('order_lat').value = position.lat;
                            document.getElementById('order_long').value = position.lng;
                        });
                    }

                    // Request User Geolocation
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            document.getElementById('order_lat').value = lat;
                            document.getElementById('order_long').value = lng;

                            orderMap.setView([lat, lng], 16);
                            orderMarker.setLatLng([lat, lng]);
                        }, function(error) {
                            console.log("Geolocation error: ", error);
                        });
                    }
                    
                    // Invalidatesize is required because map container was display:none
                    setTimeout(() => {
                        orderMap.invalidateSize();
                    }, 100);
                });
            }
        });
    </script>
    @endif

</div>

<script>
// Search class cards functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('classSearchInput');
    if(searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchValue = e.target.value.toLowerCase();
            
            // Filter featured cards
            const featuredItems = document.querySelectorAll('.featured-card-item');
            featuredItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchValue) ? '' : 'none';
            });
            
            // Filter grid cards
            const cardItems = document.querySelectorAll('.class-card-item');
            cardItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }

    // Status card selector behavior
    const statusCards = document.querySelectorAll('.svz-status-card');
    const statusValue = document.getElementById('status_value');
    if (statusCards && statusValue) {
        statusCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                statusCards.forEach(c => c.classList.remove('active'));
                // Add active class to clicked card
                this.classList.add('active');
                // Update hidden input value
                statusValue.value = this.getAttribute('data-value');
            });
        });
    }

    // Auto-open modal if there are errors on load
    @if ($errors->any())
        const modalElement = document.getElementById('modalAdd');
        if (modalElement) {
            const modalAdd = new bootstrap.Modal(modalElement);
            modalAdd.show();
        }
    @endif
});
</script>

@endsection
