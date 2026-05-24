{{-- Lokasi: resources/views/orders/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Pesanan #' . ($order['id_order'] ?? ''))
@section('breadcrumb', 'Pesanan / Detail #' . ($order['id_order'] ?? ''))

@section('content')
@php
$badgeMap = [
    'Menunggu'=>'yellow','Dikonfirmasi'=>'blue','Teknisi Berangkat'=>'indigo',
    'Sedang Dikerjakan'=>'purple','Selesai'=>'green','Dibatalkan'=>'red',
    'Disetujui'=>'green','Menunggu Persetujuan'=>'yellow','Ditolak'=>'red',
];
$stages = ['Menunggu', 'Dikonfirmasi', 'Teknisi Berangkat', 'Sedang Dikerjakan', 'Selesai'];
$currentStageIndex = array_search($order['status_order'], $stages);
if($currentStageIndex === false) $currentStageIndex = -1;
@endphp

@push('styles')
    @vite('resources/css/order-details.css')
@endpush

<div class="ats-header">
    <a href="{{ route('orders.index') }}" class="ats-back-title">
        <i class="bi bi-arrow-left"></i> Detail Pesanan
    </a>
    @if(in_array(session('servizz_user.role'), ['Admin', 'Mitra']) && !in_array($order['status_order'], ['Selesai', 'Dibatalkan']))
        <div style="position: relative;">
            <a href="#" class="ats-more-action" onclick="var d=document.getElementById('topStatusDropdown'); d.style.display=d.style.display==='block'?'none':'block'; return false;">
                Update Status <i class="bi bi-chevron-down"></i>
            </a>
            <div id="topStatusDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 16px; width: 240px; z-index: 100;">
                <form method="POST" action="{{ route('orders.status', $order['id_order']) }}" style="margin:0;">
                    @csrf
                    <label class="ats-field-label">Ubah Status Menjadi:</label>
                    <select name="status" class="ats-select" style="margin-bottom: 12px;">
                        @foreach(['Dikonfirmasi','Teknisi Berangkat','Sedang Dikerjakan','Selesai','Dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ $order['status_order']===$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="ats-btn-primary" style="width: 100%; padding: 8px;">Simpan Status</button>
                </form>
            </div>
        </div>
    @endif
</div>

<div class="ats-container">
    {{-- ── Left Column Card ── --}}
    <div class="ats-left-card">
        <div class="ats-profile">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_pelanggan']) }}&background=random" class="ats-avatar" alt="Avatar">
            <div class="ats-profile-info">
                <h3>{{ $order['nama_pelanggan'] }}</h3>
                <p>Pelanggan</p>
                @if($order['status_order'] === 'Selesai' && !empty($order['rating_nilai']))
                    <div class="ats-rating">
                        <i class="bi bi-star-fill"></i> {{ number_format($order['rating_nilai'], 1) }}
                    </div>
                @endif
            </div>
        </div>

        <div class="ats-section-title">Layanan Dipesan <span>{{ \Carbon\Carbon::parse($order['tgl_kunjungan'])->diffForHumans() }}</span></div>
        <div class="ats-section-value" style="font-size: 14px;">{{ $order['nama_service'] }}</div>
        <div class="ats-section-sub">ID Pesanan #{{ $order['id_order'] }}</div>

        <div class="ats-divider"></div>

        <div class="ats-mini-stage-labels">
            <span>Stage</span>
            <span class="active" style="display:flex; align-items:center; gap:4px;"><span style="width:6px; height:6px; background:#3b82f6; border-radius:50%; display:inline-block;"></span> {{ $order['status_order'] }}</span>
        </div>
        <div class="ats-mini-stage-bar">
            @foreach($stages as $index => $stage)
                <div class="ats-mini-bar-seg {{ $index <= $currentStageIndex ? 'active' : '' }}"></div>
            @endforeach
        </div>

        @if($order['status_order'] === 'Menunggu' && empty($order['id_tech']) && session('servizz_user.role') === 'Admin')
            <a href="#" onclick="document.getElementById('assignForm').scrollIntoView(); return false;" class="ats-main-btn" style="margin-bottom: 24px;">Tugaskan Teknisi</a>
        @elseif(session('servizz_user.role') === 'Pelanggan' && in_array($order['status_order'], ['Menunggu', 'Dikonfirmasi']))
            <form method="POST" action="{{ route('orders.pay', $order['id_order']) }}" style="width:100%; margin-bottom: 24px;">
                @csrf
                <button type="submit" class="ats-main-btn ats-main-btn-primary"><i class="bi bi-credit-card-fill" style="margin-right:8px;"></i> Bayar Midtrans</button>
            </form>
        @else
            <div class="ats-main-btn" style="color: #94a3b8; cursor: default; margin-bottom: 24px;">{{ $order['status_order'] }}</div>
        @endif

        <h3 class="ats-contact-title">Contact</h3>
        <div class="ats-contact-item">
            <i class="bi bi-telephone ats-contact-icon"></i>
            <div class="ats-contact-text">
                <h4>Phone</h4>
                <p>{{ $order['hp_pelanggan'] }}</p>
            </div>
        </div>
        <div class="ats-contact-item">
            <i class="bi bi-geo-alt ats-contact-icon"></i>
            <div class="ats-contact-text">
                <h4>Address</h4>
                <p>{{ $order['alamat_pelanggan'] ?? '—' }}</p>
            </div>
        </div>
        @if(!empty($order['latitude']) && !empty($order['longitude']))
        <div class="ats-contact-item">
            <i class="bi bi-map ats-contact-icon"></i>
            <div class="ats-contact-text">
                <h4>Maps</h4>
                <a href="https://maps.google.com/?q={{ $order['latitude'] }},{{ $order['longitude'] }}" target="_blank" style="color:#4f46e5;">Buka di Google Maps</a>
            </div>
        </div>
        <div style="width: 100%; height: 140px; border-radius: 8px; border: 1px solid #cbd5e1; overflow: hidden; margin-top: 8px;">
            <div id="showMap" style="width: 100%; height: 100%;"></div>
        </div>
        @endif
    </div>

    {{-- ── Right Column ── --}}
    <div class="ats-right-col">
        <div class="ats-tabs">
            <a href="#" class="ats-tab active">Hiring Progress</a>
            @if(session('servizz_user.role') === 'Mitra' || !empty($order['id_nego']))
                <a href="#notes-section" class="ats-tab">Diagnosa & Biaya</a>
            @endif
            @if(count($evidence))
                <a href="#evidence-section" class="ats-tab">Bukti Kerja</a>
            @endif
        </div>

        <div class="ats-content">
            <div class="ats-stage-header">
                <h2>Current Stage</h2>
                @if(session('servizz_user.role') === 'Pelanggan' && $order['status_order'] === 'Selesai')
                    <a href="#rating-section" class="ats-rating-btn" onclick="document.getElementById('rating-section').scrollIntoView(); return false;">Give Rating <i class="bi bi-chevron-down"></i></a>
                @endif
            </div>

            <div class="ats-big-tracker">
                @foreach($stages as $index => $stage)
                    @php
                        $class = '';
                        if($index < $currentStageIndex) $class = 'past';
                        elseif($index === $currentStageIndex) $class = 'active';
                    @endphp
                    <div class="ats-tracker-seg {{ $class }}">{{ $stage }}</div>
                @endforeach
            </div>

            <h3 class="ats-stage-info-title">Stage Info</h3>
            <div class="ats-info-grid">
                <div class="ats-info-box">
                    <h4>Jadwal Kunjungan</h4>
                    <p>{{ \Carbon\Carbon::parse($order['tgl_kunjungan'])->locale('id')->isoFormat('D MMM Y, HH:mm') }}</p>
                </div>
                <div class="ats-info-box">
                    <h4>Status Pesanan</h4>
                    <span class="ats-status-badge {{ $badgeMap[$order['status_order']] ?? 'gray' }}">{{ $order['status_order'] }}</span>
                </div>
                <div class="ats-info-box">
                    <h4>Total Biaya</h4>
                    @php $totalBiaya = (!empty($order['id_nego'])) ? ($order['total_biaya']??0) : ($order['biaya_kunjungan']??0); @endphp
                    <p>Rp {{ number_format($totalBiaya,0,',','.') }}</p>
                </div>
                <div class="ats-info-box">
                    <h4>Assigned to</h4>
                    <div class="ats-assigned-avatars">
                        @if($order['nama_mitra'])
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra']) }}&background=random" title="Teknisi: {{ $order['nama_mitra'] }}">
                        @endif
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_pelanggan']) }}&background=random" title="Pelanggan: {{ $order['nama_pelanggan'] }}">
                    </div>
                </div>
            </div>

            @if(in_array(session('servizz_user.role'), ['Admin', 'Mitra']) && !in_array($order['status_order'], ['Selesai', 'Dibatalkan']))
                <button class="ats-next-btn ready" onclick="document.getElementById('statusForm').style.display='block'; this.style.display='none';">Move To Next Step</button>
                <div id="statusForm" style="display:none; margin-bottom: 30px; background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <form method="POST" action="{{ route('orders.status', $order['id_order']) }}">
                        @csrf
                        <div class="ats-field-group" style="margin-bottom:0;">
                            <label class="ats-field-label">Update Status Pesanan</label>
                            <div style="display:flex; gap:12px;">
                                <select name="status" class="ats-select" style="margin-bottom:0; width: 200px;">
                                    @foreach(['Dikonfirmasi','Teknisi Berangkat','Sedang Dikerjakan','Selesai','Dibatalkan'] as $s)
                                    <option value="{{ $s }}" {{ $order['status_order']===$s?'selected':'' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ats-btn-primary">Simpan Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="ats-next-btn" style="cursor: default;">Move To Next Step</div>
            @endif

            {{-- Assign Form --}}
            @if(session('servizz_user.role') === 'Admin' && empty($order['nama_mitra']))
                <div id="assignForm" class="ats-note-card" style="border-color:#3b82f6; background:#eff6ff;">
                    <div class="ats-note-top">
                        <div class="ats-note-user">
                            <i class="bi bi-person-fill-add" style="font-size:24px; color:#2563eb;"></i>
                            <h4>Tugaskan Teknisi</h4>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('orders.assign', $order['id_order']) }}">
                        @csrf
                        <select name="id_tech" class="ats-select" required>
                            <option value="">— pilih teknisi —</option>
                            @foreach($techs as $t)
                            <option value="{{ $t['id_tech'] }}">{{ $t['nama'] }} (⭐{{ number_format($t['rating_rata2'],1) }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="ats-btn-primary" style="width:100%;">Tugaskan Sekarang</button>
                    </form>
                </div>
            @endif

            {{-- Notes Section (Diagnosa, Negosiasi) --}}
            <div id="notes-section" class="ats-notes-header">
                <h3>Notes</h3>
                @if(session('servizz_user.role') === 'Mitra' && empty($order['id_nego']))
                    <a href="#" class="ats-add-note">+ Add Notes (Diagnosa)</a>
                @endif
            </div>

            {{-- Input Diagnosa Mitra --}}
            @if(session('servizz_user.role') === 'Mitra' && empty($order['id_nego']))
                <div class="ats-note-card">
                    <form method="POST" action="{{ route('orders.nego.store', $order['id_order']) }}">
                        @csrf
                        <div class="ats-field-group">
                            <label class="ats-field-label">Deskripsi Kerusakan <span>*</span></label>
                            <textarea name="deskripsi_kerusakan" class="ats-textarea" style="min-height:80px;" required placeholder="Jelaskan detail kerusakan hasil diagnosa..."></textarea>
                        </div>
                        <div class="ats-field-group">
                            <label class="ats-field-label">Rincian Barang / Sparepart</label>
                            <textarea name="rincian_barang" class="ats-textarea" style="min-height:60px;" placeholder="Rincian sparepart yang diganti..."></textarea>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div class="ats-field-group">
                                <label class="ats-field-label">Harga Barang (Rp) <span>*</span></label>
                                <input type="number" name="harga_barang" class="ats-input" min="0" value="0" required>
                            </div>
                            <div class="ats-field-group">
                                <label class="ats-field-label">Biaya Jasa (Rp) <span>*</span></label>
                                <input type="number" name="biaya_jasa" class="ats-input" min="0" value="0" required>
                            </div>
                        </div>
                        <button type="submit" class="ats-btn-primary" style="width:100%;">Kirim Rincian Biaya</button>
                    </form>
                </div>
            @endif

            {{-- Existing Note (Nego Data) --}}
            @if(!empty($order['id_nego']))
                <div class="ats-note-card">
                    <div class="ats-note-top">
                        <div class="ats-note-user">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra'] ?? 'Teknisi') }}&background=random" alt="Avatar">
                            <h4>{{ $order['nama_mitra'] ?? 'Teknisi' }} <span style="font-weight:400; color:#64748b;">(Teknisi)</span></h4>
                        </div>
                        <span class="ats-status-badge {{ $badgeMap[$order['status_acc']] ?? 'gray' }}">{{ $order['status_acc'] }}</span>
                    </div>
                    <div class="ats-note-body">
                        <strong>Diagnosa:</strong> {{ $order['deskripsi_kerusakan'] }} <br>
                        <strong>Sparepart:</strong> {{ $order['rincian_barang'] ?? '-' }} <br><br>
                        <strong>Harga Barang:</strong> Rp {{ number_format($order['harga_barang']??0,0,',','.') }} <br>
                        <strong>Biaya Jasa:</strong> Rp {{ number_format($order['biaya_jasa']??0,0,',','.') }}
                    </div>
                    
                    @if(session('servizz_user.role') === 'Pelanggan' && $order['status_acc'] === 'Menunggu Persetujuan')
                        <div style="display:flex; gap:12px; margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                            <form method="POST" action="{{ route('orders.nego.decide', $order['id_order']) }}" style="flex:1;">
                                @csrf
                                <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                                <input type="hidden" name="is_approved" value="1">
                                <button type="submit" class="ats-btn-primary" style="width:100%; background:#10b981;">Setujui Biaya</button>
                            </form>
                            <form method="POST" action="{{ route('orders.nego.decide', $order['id_order']) }}" style="flex:1;">
                                @csrf
                                <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                                <input type="hidden" name="is_approved" value="0">
                                <button type="submit" class="ats-btn-primary" style="width:100%; background:#ef4444;">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Evidence Section --}}
            @if(session('servizz_user.role') === 'Mitra' && !empty($order['id_nego']))
                <div id="evidence-section" class="ats-notes-header">
                    <h3>Bukti Kerja (Evidence)</h3>
                </div>
                <div class="ats-note-card">
                    <form method="POST" action="{{ route('orders.evidence.store', $order['id_order']) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nego_id" value="{{ $order['id_nego'] }}">
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <div class="ats-field-group">
                                <label class="ats-field-label">Foto Kerusakan/Perbaikan <span>*</span></label>
                                <input type="file" name="foto_kerusakan" class="ats-input" required>
                            </div>
                            <div class="ats-field-group">
                                <label class="ats-field-label">Foto Nota/Struk</label>
                                <input type="file" name="foto_nota" class="ats-input">
                            </div>
                        </div>
                        <div class="ats-field-group">
                            <label class="ats-field-label">Keterangan Bukti</label>
                            <input type="text" name="deskripsi" class="ats-input" placeholder="Contoh: Pekerjaan selesai">
                        </div>
                        <button type="submit" class="ats-btn-primary" style="background:#0ea5e9;">Unggah Bukti</button>
                    </form>
                </div>
            @endif

            @if(count($evidence))
                @foreach($evidence as $index => $ev)
                <div class="ats-note-card">
                    <div class="ats-note-top">
                        <div class="ats-note-user">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order['nama_mitra'] ?? 'Teknisi') }}&background=random" alt="Avatar">
                            <h4>{{ $order['nama_mitra'] ?? 'Teknisi' }} <span style="font-weight:400; color:#64748b;">mengunggah bukti</span></h4>
                        </div>
                        <span class="ats-note-time">{{ \Carbon\Carbon::parse($ev['created_at'])->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    </div>
                    <div class="ats-note-body">
                        {{ $ev['deskripsi'] }}
                        <div style="display:flex; gap:12px; margin-top: 12px;">
                            @if(!empty($ev['foto_kerusakan']))
                                <a href="{{ $ev['foto_kerusakan'] }}" target="_blank">
                                    <img src="{{ $ev['foto_kerusakan'] }}" style="width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;" onerror="this.style.display='none'">
                                </a>
                            @endif
                            @if(!empty($ev['foto_nota']))
                                <a href="{{ $ev['foto_nota'] }}" target="_blank">
                                    <img src="{{ $ev['foto_nota'] }}" style="width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;" onerror="this.style.display='none'">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            {{-- Rating Section --}}
            @if(session('servizz_user.role') === 'Pelanggan' && $order['status_order'] === 'Selesai')
                <div id="rating-section" class="ats-notes-header">
                    <h3>Rating & Ulasan</h3>
                </div>
                <div class="ats-note-card" style="border-color:#fcd34d; background:#fffbeb;">
                    @if(empty($order['id_rating']))
                        <form method="POST" action="{{ route('orders.rating', $order['id_order']) }}">
                            @csrf
                            <div class="ats-field-group">
                                <label class="ats-field-label" style="color:#d97706;">Nilai (1-5 Bintang) <span>*</span></label>
                                <select name="nilai" class="ats-select" style="border-color:#fcd34d;" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                    <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                    <option value="3">⭐⭐⭐ (Cukup)</option>
                                    <option value="2">⭐⭐ (Kurang)</option>
                                    <option value="1">⭐ (Sangat Kurang)</option>
                                </select>
                            </div>
                            <div class="ats-field-group">
                                <label class="ats-field-label" style="color:#d97706;">Komentar Ulasan</label>
                                <textarea name="komentar" class="ats-textarea" style="border-color:#fcd34d; min-height:60px;" placeholder="Tulis pengalaman Anda..."></textarea>
                            </div>
                            <button type="submit" class="ats-btn-primary" style="background:#f59e0b; width:100%;">Kirim Ulasan</button>
                        </form>
                    @else
                        <div class="ats-note-top">
                            <div class="ats-note-user">
                                <h4 style="color:#b45309;">Rating Anda</h4>
                            </div>
                            <span style="font-size:16px; color:#f59e0b;">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $order['rating_nilai'] ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                        </div>
                        <div class="ats-note-body" style="font-style:italic; color:#92400e;">
                            "{{ $order['rating_komentar'] ?: 'Tidak ada komentar ulasan.' }}"
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
@endpush

@section('scripts')
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
@endsection

@endsection