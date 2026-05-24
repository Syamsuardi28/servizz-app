<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Servizz.io</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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

    <!-- Right Side: Login Form -->
    <div class="login-right">
        <div class="login-form-box">
            
            <h1 class="form-header-title">Login</h1>

            {{-- Alert --}}
            @if(session('flash_message'))
                <div class="custom-alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i> {{ session('flash_message') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- Email Input -->
                <div class="input-group-custom">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@servizz.com') }}" placeholder="mitcheldesigner@gmail.com" required autofocus>
                </div>

                <!-- Password Input -->
                <div class="input-group-custom">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="••••••••••••••••" required>
                        <button type="button" class="toggle-password" id="btnTogglePassword" title="Tampilkan sandi">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Login
                </button>
            </form>

            <div class="social-divider">or</div>

            <div class="social-row">
                <a href="#" class="social-btn fb"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-btn google"><i class="bi bi-google"></i></a>
            </div>

            <div class="footer-text">
                Don't have an account? <a href="{{ route('register') }}">Create Account</a>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>