@extends('settings.layout')

@section('setting_content')
<h2 style="font-size: 20px; font-weight: 700; color: var(--txt); margin-bottom: 24px;">Ganti Kata Sandi</h2>

<form method="POST" action="{{ route('settings.password.update') }}">
    @csrf
    <div style="max-width: 500px;">
        
        <div class="st-form-group">
            <label class="st-label">Kata Sandi Saat Ini <span class="req">*</span></label>
            <input type="password" name="current_password" class="st-input" required placeholder="Masukkan kata sandi saat ini">
        </div>

        <div class="st-form-group">
            <label class="st-label">Kata Sandi Baru <span class="req">*</span></label>
            <input type="password" name="new_password" class="st-input" required placeholder="Minimal 6 karakter" minlength="6">
        </div>

        <div class="st-form-group">
            <label class="st-label">Konfirmasi Kata Sandi Baru <span class="req">*</span></label>
            <input type="password" name="new_password_confirmation" class="st-input" required placeholder="Ulangi kata sandi baru" minlength="6">
        </div>

    </div>

    <button type="submit" class="btn-save">Perbarui Kata Sandi</button>
</form>
@endsection
