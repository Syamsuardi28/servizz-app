@extends('settings.layout')

@section('setting_content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC] font-heading mb-6">Ganti Kata Sandi</h2>

    <form method="POST" action="{{ route('settings.password.update') }}" class="space-y-6">
        @csrf
        
        <div>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Saat Ini <span class="text-red-500">*</span></label>
                    <x-input type="password" name="current_password" required placeholder="Masukkan kata sandi saat ini" icon="lock" />
                </div>

                <hr class="border-gray-100 dark:border-[#3E3E3A] my-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Baru <span class="text-red-500">*</span></label>
                    <x-input type="password" name="new_password" required placeholder="Minimal 6 karakter" minlength="6" icon="key" />
                    <p class="text-xs text-gray-500 mt-1">Pastikan kata sandi baru Anda kuat dan sulit ditebak.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span></label>
                    <x-input type="password" name="new_password_confirmation" required placeholder="Ulangi kata sandi baru" minlength="6" icon="check-circle" />
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="save">Perbarui Kata Sandi</x-button>
        </div>
    </form>
</div>
@endsection
