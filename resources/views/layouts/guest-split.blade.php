<!DOCTYPE html>
<html lang="id" class="dark overscroll-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') — Servizz.io</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 dark:text-[#EDEDEC] bg-[#fdfdfc] dark:bg-[#0a0a0a] min-h-screen flex items-center justify-center p-4 py-8 sm:p-6 lg:p-12 relative overflow-x-hidden overscroll-none transition-colors duration-300">
    
    <!-- Abstract Backgrounds (For the outer body) -->
    <div class="absolute top-0 inset-x-0 h-screen bg-gradient-to-b from-primary-50/50 dark:from-primary-900/10 to-transparent -z-10 pointer-events-none"></div>
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-amber-400/10 dark:bg-amber-400/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <!-- Main Container -->
    <div class="w-full max-w-[1200px] bg-white dark:bg-[#0f0f0f] rounded-[2rem] shadow-2xl shadow-gray-200/50 dark:shadow-black/60 flex flex-col lg:flex-row overflow-hidden min-h-[700px] border border-white dark:border-[#1f1f1e] relative z-10">
        
        <!-- Left Side (Info Panel) -->
        <div class="w-full lg:w-1/2 p-8 lg:p-12 xl:p-16 flex flex-col justify-between relative bg-[#fdfdfc] dark:bg-[#0f0f0f] border-r border-transparent dark:border-[#1f1f1e]">
            <!-- Decorative Elements inside left panel -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50 dark:bg-primary-900/10 rounded-bl-[100px] -z-10 opacity-50"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-primary-100 dark:bg-primary-900/20 rounded-full blur-3xl -z-10 opacity-50"></div>
            
            <!-- Back Button -->
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors mb-8 group w-max">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-[#1f1f1e] group-hover:bg-primary-50 dark:group-hover:bg-primary-900/30 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                </div>
                Kembali ke Landing Page
            </a>

            <!-- Top Branding -->
            <div class="flex items-center gap-3 mb-12">
                <div class="flex items-center justify-center w-10 h-10 text-white rounded-xl bg-primary-500 font-bold text-xl shadow-lg shadow-primary-500/30">
                    S
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Servizz.io</span>
            </div>

            <!-- Content -->
            <div class="flex-1 max-w-lg">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-bold text-xs mb-6 border border-primary-100 dark:border-primary-900/30">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    Platform Manajemen Jasa Modern
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
                    Kelola Bisnis Jasa <br> Jadi <span class="text-primary-500">Lebih Mudah</span>
                </h1>
                
                <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-10">
                    Servizz.io membantu Anda mengelola pelanggan, layanan, tim, dan laporan dalam satu platform yang terintegrasi.
                </p>

                <!-- Features -->
                <div class="space-y-6 mb-12">
                    <div class="flex gap-4">
                        <div class="flex items-center justify-center w-12 h-12 shrink-0 bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] rounded-2xl shadow-sm text-primary-500">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-200 text-sm">Aman & Terpercaya</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 leading-relaxed">Data Anda terlindungi dengan sistem keamanan tingkat enterprise.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex items-center justify-center w-12 h-12 shrink-0 bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] rounded-2xl shadow-sm text-primary-500">
                            <i data-lucide="zap" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-200 text-sm">Cepat & Efisien</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 leading-relaxed">Automasi proses bisnis untuk meningkatkan produktivitas tim Anda.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex items-center justify-center w-12 h-12 shrink-0 bg-white dark:bg-[#161615] border border-gray-100 dark:border-[#3E3E3A] rounded-2xl shadow-sm text-primary-500">
                            <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-200 text-sm">Laporan Real-time</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 leading-relaxed">Pantau perkembangan bisnis dalam dashboard yang informatif.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trusted By -->
            <div class="mt-auto pt-6 border-t border-gray-100 dark:border-[#1f1f1e]">
                <p class="text-xs font-bold text-gray-900 dark:text-gray-500 mb-4">Dipercaya oleh banyak perusahaan</p>
                <div class="flex flex-wrap items-center gap-6 opacity-60 dark:opacity-30 grayscale hover:grayscale-0 dark:hover:opacity-60 transition-all duration-300">
                    <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-400 text-lg"><i data-lucide="aperture" class="w-5 h-5"></i> acme</div>
                    <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-400 text-lg"><i data-lucide="box" class="w-5 h-5"></i> kanba</div>
                    <div class="flex items-center gap-2 font-black tracking-tighter text-gray-800 dark:text-gray-400 text-lg">aven.</div>
                    <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-400 text-lg"><i data-lucide="hexagon" class="w-5 h-5"></i> goldline</div>
                </div>
            </div>
        </div>

        <!-- Right Side (Auth Panel) -->
        <div class="w-full lg:w-1/2 bg-[#161615] text-[#EDEDEC] p-6 sm:p-8 lg:p-12 xl:p-16 flex flex-col justify-center relative min-h-full">
            
            <div class="w-full max-w-md mx-auto text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#3E3E3A]/40 border border-[#3E3E3A] text-primary-500 shadow-inner mb-6">
                    <i data-lucide="lock" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-white mb-2">
                    @yield('header_title', 'Selamat Datang Kembali')
                </h2>
                <p class="text-sm text-gray-400">
                    @yield('header_subtitle', 'Masuk ke akun Anda untuk melanjutkan')
                </p>
            </div>

            <div class="w-full max-w-md mx-auto">
                <!-- Flash Messages -->
                @if(session('flash_message'))
                    @php $type = session('flash_type') === 'error' ? 'danger' : 'success'; @endphp
                    <x-alert :type="$type" :message="session('flash_message')" />
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-900/20 border border-red-500/30 text-red-400 text-sm font-medium">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <strong>Error</strong>
                        </div>
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-900/20 border border-green-500/30 text-green-400 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-900/20 border border-red-500/30 text-red-400 text-sm font-medium">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </div>

</body>
</html>
