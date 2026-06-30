@component('mail::message')
# Update Status Pesanan

Halo **{{ $orderData['nama_pelanggan'] }}**,

Status pesanan Anda (ID: **#{{ $orderData['id_order'] }}**) saat ini telah diperbarui.

**Status Baru:** {{ $orderData['status_order'] }}

**Detail Pesanan:**
- Layanan: {{ $orderData['nama_service'] ?? 'Layanan' }}
- Tanggal Kunjungan: {{ \Carbon\Carbon::parse($orderData['tgl_kunjungan'])->locale('id')->isoFormat('D MMM Y, HH:mm') }}
- Teknisi: {{ $orderData['nama_mitra'] ?? 'Belum Ditugaskan' }}

@component('mail::button', ['url' => route('orders.show', $orderData['id_order'])])
Lihat Detail Pesanan
@endcomponent

Terima kasih telah menggunakan layanan kami,<br>
{{ config('app.name') }}
@endcomponent
