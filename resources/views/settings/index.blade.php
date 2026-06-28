
@push('styles')
    @vite('resources/css/settings.css')
@endpush
@extends('settings.layout')

@push('setting_styles')
@endpush

@section('setting_content')
{{-- Avatar Section --}}
<div class="avatar-section">
    <div class="avatar-circle-wrapper">
        <div class="avatar-circle">
            @if(!empty($user['foto_profil']))
                <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ $user['foto_profil'] }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
            @else
                {{ strtoupper(substr($user['nama'] ?? 'U', 0, 1)) }}
            @endif
        </div>
        <label for="avatar-upload" class="avatar-camera-btn">
            <i class="bi bi-camera"></i>
        </label>
    </div>
    <div class="avatar-actions">
        <form action="{{ route('settings.avatar.upload') }}" method="POST" enctype="multipart/form-data" id="avatar-form">
            @csrf
            <input type="file" name="avatar" id="avatar-upload" style="display: none;" onchange="if(this.files[0].size > 4 * 1024 * 1024) { alert('Ukuran gambar terlalu besar! Vercel membatasi maksimal 4.5 MB. Harap pilih gambar yang ukurannya lebih kecil (di bawah 4 MB).'); this.value = ''; } else { document.getElementById('avatar-form').submit(); }" accept="image/*">
            <label for="avatar-upload" class="btn-upload" style="display:inline-block; margin:0; cursor:pointer;">Unggah Baru</label>
        </form>
        <form action="{{ route('settings.avatar.delete') }}" method="POST" id="form-delete-avatar">
            @csrf
            <button type="button" class="btn-delete-avatar" onclick="confirmDeleteAvatar()">Hapus avatar</button>
        </form>
    </div>
</div>

{{-- Form Settings --}}
<form method="POST" action="{{ route('settings.profile.update') }}">
    @csrf
    <div class="settings-form-grid">
        
        <div class="st-form-group">
            <label class="st-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="nama" class="st-input" value="{{ old('nama', $user['nama'] ?? '') }}" required placeholder="Nama Lengkap">
        </div>

        <div class="st-form-group">
            <label class="st-label">Email</label>
            <input type="email" class="st-input" value="{{ $user['email'] ?? '' }}" disabled>
        </div>

        <div class="st-form-group">
            <label class="st-label">Nomor Telepon <span class="req">*</span></label>
            <input type="text" name="no_hp" class="st-input" value="{{ old('no_hp', $user['no_hp'] ?? '') }}" required placeholder="Contoh: 08123456789">
        </div>

        @if(session('servizz_user.role') === 'Mitra')
        <div class="st-form-group">
            <label class="st-label">Keahlian (Mitra)</label>
            <input type="text" name="keahlian" class="st-input" value="{{ old('keahlian', $user['keahlian'] ?? '') }}" placeholder="Contoh: AC, Listrik, Plumbing">
        </div>
        @else
        <div class="st-form-group">
            <label class="st-label">Role</label>
            <input type="text" class="st-input" value="{{ $user['role'] ?? 'Pelanggan' }}" disabled>
        </div>
        @endif

        <div class="st-form-group form-col-full">
            <label class="st-label">Alamat Domisili / Tempat Tinggal <span class="req">*</span></label>
            <textarea name="alamat" class="st-input" required placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user['alamat'] ?? '') }}</textarea>
        </div>

    </div>

    <button type="submit" class="btn-save">Simpan Perubahan</button>
</form>

<script>
function confirmDeleteAvatar() {
    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: "Apakah Anda yakin ingin menghapus foto profil ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-avatar').submit();
        }
    })
}
</script>
@endsection
