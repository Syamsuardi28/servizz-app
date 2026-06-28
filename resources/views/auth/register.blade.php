<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Servizz.io</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    @vite(['resources/css/variables.css', 'resources/css/auth.css'])
</head>
<body>

<div class="login-container">

    <!-- Left Side: Banner / Illustration -->
    <div class="login-left">
        <div class="glow-circle glow-1"></div>
        <div class="glow-circle glow-2"></div>
        
        <div class="left-brand">
            <div class="brand-logo-circle"></div>
            <span class="brand-name">Servizz.io</span>
        </div>

        <div class="left-content">
            <h2 class="left-title">Dapatkan layanan jasa terbaik dengan mudah</h2>
            <p class="left-subtitle">Platform terpercaya untuk menghubungkan Anda dengan mitra penyedia jasa handal, profesional, dan bersertifikat di sekitar Anda.</p>
        </div>

        <!-- 3D Folder Illustration -->
        <div class="left-illustration-wrap">
            <div class="folder-3d">
                <div class="doc-card doc-card-1">
                    <div class="doc-img">⭐</div>
                    <div class="doc-bar primary"></div>
                    <div class="doc-bar success"></div>
                </div>
                <div class="doc-card doc-card-2">
                    <div class="doc-img">🛠️</div>
                    <div class="doc-bar warning"></div>
                    <div class="doc-bar"></div>
                </div>
                <div class="folder-front"></div>
            </div>
            <div class="magnifier-3d"></div>
        </div>
    </div>

    <!-- Right Side: Register Form -->
    <div class="login-right">
        <div class="login-form-box">
            
            <h1 class="form-header-title">Daftar Akun</h1>

            @if(session('error'))
                <div class="custom-alert alert-error">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="custom-alert alert-error">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
                @csrf

                <!-- Daftar Sebagai (Role Selector) -->
                <span class="role-label-title">Daftar Sebagai</span>
                <div class="role-selector-row">
                    <label class="role-card active" id="roleLabelPelanggan">
                        <input type="radio" name="role" value="Pelanggan" checked style="display:none">
                        <i class="bi bi-person-fill"></i>
                        <span>Pelanggan</span>
                    </label>
                    <label class="role-card" id="roleLabelMitra">
                        <input type="radio" name="role" value="Mitra" style="display:none">
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Mitra Jasa</span>
                    </label>
                </div>

                <!-- Nama Lengkap -->
                <div class="input-group-custom">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="John Doe" required autofocus>
                </div>

                <!-- Email -->
                <div class="input-group-custom">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="johndoe@gmail.com" required>
                </div>

                <!-- Password -->
                <div class="input-group-custom">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Min. 6 karakter" required>
                        <button type="button" class="toggle-password" id="btnTogglePassword" title="Tampilkan sandi">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- No. HP -->
                <div class="input-group-custom">
                    <label for="no_hp">No. WhatsApp / HP</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08123456789" required>
                </div>

                <!-- Alamat -->
                <div class="input-group-custom">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="2" placeholder="Jl. Raya Kemerdekaan No. 45, Jakarta" required>{{ old('alamat') }}</textarea>
                </div>

                <!-- Dokumen Mitra (Khusus Mitra) -->
                <!-- Dokumen Mitra (Khusus Mitra) -->
                <div id="mitraFiles" style="display: none;">
                    <div class="input-group-custom file-upload-wrapper">
                        <span class="file-label-title">Upload SKCK (Wajib untuk Mitra)</span>
                        <div class="file-upload-btn-container">
                            <label for="file_skck" class="file-upload-btn">
                                <i class="bi bi-cloud-arrow-up"></i> Pilih File
                            </label>
                            <span id="file_skck_name" class="file-name-display">Belum ada file dipilih.</span>
                        </div>
                        <input type="file" id="file_skck" name="file_skck" accept=".pdf,image/*" style="display: none;">
                    </div>
                    
                    <div class="input-group-custom file-upload-wrapper">
                        <span class="file-label-title">Upload Sertifikat Keahlian (Wajib untuk Mitra)</span>
                        <div class="file-upload-btn-container">
                            <label for="file_sertifikat" class="file-upload-btn">
                                <i class="bi bi-cloud-arrow-up"></i> Pilih File
                            </label>
                            <span id="file_sertifikat_name" class="file-name-display">Belum ada file dipilih.</span>
                        </div>
                        <input type="file" id="file_sertifikat" name="file_sertifikat" accept=".pdf,image/*" style="display: none;">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Sekarang
                </button>
            </form>

            <div class="footer-text">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('js/auth.js') }}"></script>
<script src="{{ asset('js/register.js') }}"></script>
</body>
</html>

