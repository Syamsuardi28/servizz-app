<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') — Servizz.io</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-background relative overflow-hidden min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    
    <!-- Abstract Backgrounds (Matching Landing Page) -->
    <div class="absolute top-0 inset-x-0 h-screen bg-gradient-to-b from-primary-50/50 to-background dark:from-primary-900/10 dark:to-transparent -z-10"></div>
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-amber-400/10 dark:bg-amber-400/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-primary-500 text-white flex items-center justify-center font-bold font-heading text-xl shadow-lg shadow-primary-500/30">
                S
            </div>
            <span class="text-2xl font-bold font-heading tracking-tight">Servizz.io</span>
        </a>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-gray-100 font-heading">
            @yield('header_title')
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            @yield('header_subtitle')
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        
        @if(session('flash_message'))
            @php $type = session('flash_type') === 'error' ? 'danger' : 'success'; @endphp
            <x-alert :type="$type" :message="session('flash_message')" />
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Glass Card -->
        <div class="bg-white/80 dark:bg-[#161615]/80 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-gray-200/50 dark:shadow-black/50 sm:rounded-2xl sm:px-10 border border-white dark:border-[#3E3E3A]">
            @yield('content')
        </div>
        
    </div>
    
</body>
</html>
