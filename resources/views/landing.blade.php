<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Servizz - Platform Jasa Profesional Terpercaya">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Servizz - Jasa Profesional</title>

    <!-- Preconnect for fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @viteReactRefresh
    @vite(['resources/css/landing.css', 'resources/js/landing.jsx'])
</head>
<body class="antialiased font-sans text-gray-900 bg-white dark:bg-[#0a0a0a] dark:text-gray-100">
    <div id="landing-app" data-login-url="{{ route('login') }}" data-register-url="{{ route('register') }}" data-dashboard-url="{{ url('/dashboard') }}" data-is-authenticated="{{ Auth::check() ? 'true' : 'false' }}"></div>
</body>
</html>
