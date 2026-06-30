@extends('settings.layout')

@section('setting_content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-6">Profil Pribadi</h2>

    <!-- Avatar Section -->
    <div class="mb-8 flex flex-col sm:flex-row items-center sm:items-start gap-8">
        
        <div class="relative group shrink-0">
            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-gray-50 dark:border-[#20201f] shadow-lg bg-gray-100 dark:bg-[#262625] flex items-center justify-center overflow-hidden transition-transform duration-300 group-hover:scale-[1.02]">
                @if(!empty($user['foto_profil']))
                    <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ $user['foto_profil'] }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span class="text-4xl font-bold text-gray-400 dark:text-gray-500 font-heading">{{ strtoupper(substr($user['nama'] ?? 'U', 0, 1)) }}</span>
                @endif
            </div>
            
            <label for="avatar-upload" class="absolute bottom-1 right-1 w-9 h-9 bg-primary text-white rounded-full border-[3px] border-white dark:border-[#161615] shadow-sm flex items-center justify-center cursor-pointer hover:bg-primary/90 transition-colors z-10 group-hover:scale-110">
                <i data-lucide="camera" class="w-4 h-4"></i>
            </label>
        </div>

        <div class="text-center sm:text-left flex-1">
            <h3 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">Foto Profil Anda</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-6 max-w-sm mx-auto sm:mx-0">Pilih foto yang menampilkan wajah Anda dengan jelas. Maksimal ukuran file 4 MB (PNG, JPG, JPEG).</p>
            
            <div class="flex items-center justify-center sm:justify-start gap-3">
                <form action="{{ route('settings.avatar.upload') }}" method="POST" enctype="multipart/form-data" id="avatar-form">
                    @csrf
                    <input type="file" name="avatar" id="avatar-upload" class="hidden" accept="image/*" onchange="if(this.files[0].size > 4*1024*1024) { alert('Maksimal 4 MB!'); this.value=''; } else { document.getElementById('avatar-form').submit(); }">
                    <button type="button" onclick="document.getElementById('avatar-upload').click();" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-[#20201f] dark:hover:bg-[#262625] text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl transition-colors border border-gray-200 dark:border-[#3E3E3A]">
                        Ubah Foto Profil
                    </button>
                </form>
                
                @if(!empty($user['foto_profil']))
                <form action="{{ route('settings.avatar.delete') }}" method="POST" id="form-delete-avatar">
                    @csrf
                    <button type="button" class="px-4 py-2.5 text-sm font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl transition-colors" onclick="confirmDeleteAvatar()">
                        Hapus Foto
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Profile -->
    <div>
        <form method="POST" action="{{ route('settings.profile.update') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <x-input name="nama" value="{{ old('nama', $user['nama'] ?? '') }}" required placeholder="Masukkan nama lengkap Anda" icon="user" class="py-2.5" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email</label>
                    <x-input type="email" value="{{ $user['email'] ?? '' }}" disabled icon="mail" class="py-2.5" />
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1"><i data-lucide="info" class="w-3.5 h-3.5"></i> Alamat email tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Telepon / WA <span class="text-red-500">*</span></label>
                    <x-input name="no_hp" value="{{ old('no_hp', $user['no_hp'] ?? '') }}" required placeholder="Contoh: 08123456789" icon="phone" class="py-2.5" />
                </div>

                @if(session('servizz_user.role') === 'Mitra')
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Keahlian Utama</label>
                    <x-input name="keahlian" value="{{ old('keahlian', $user['keahlian'] ?? '') }}" placeholder="Contoh: Perbaikan AC, Teknisi Listrik..." icon="wrench" class="py-2.5" />
                </div>
                @else
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Peran Akun</label>
                    <x-input type="text" value="{{ $user['role'] ?? 'Pelanggan' }}" disabled icon="shield" class="py-2.5" />
                </div>
                @endif

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Domisili <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" required placeholder="Tuliskan alamat lengkap Anda..." class="w-full rounded-xl border border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#1f1f1e] text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 dark:placeholder-gray-500 shadow-sm transition-all duration-200 focus:border-primary-500 focus:ring focus:ring-primary-500/20 px-4 py-3 text-sm resize-none">{{ old('alamat', $user['alamat'] ?? '') }}</textarea>
                </div>

            </div>

            <div class="pt-6 mt-6 border-t border-gray-100 dark:border-[#3E3E3A] flex justify-end">
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary/90 text-white font-semibold text-sm rounded-xl transition-colors shadow-sm shadow-primary/20 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteAvatar() {
    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: "Anda yakin ingin menghapus foto profil ini secara permanen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl shadow-xl border border-gray-100 dark:border-[#3E3E3A] dark:bg-[#161615]',
            title: 'text-gray-900 dark:text-white',
            htmlContainer: 'text-gray-500 dark:text-gray-400',
            confirmButton: 'rounded-xl text-sm font-bold',
            cancelButton: 'rounded-xl text-sm font-bold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-avatar').submit();
        }
    })
}
</script>
@endsection
