<!DOCTYPE html>
<html lang="id" class="dark overscroll-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') — Servizz.io</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GSAP for smooth animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Spline 3D Viewer -->
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.0.51/build/spline-viewer.js"></script>

    <style>
        /* Custom Noise Texture */
        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
            z-index: 1;
        }

        /* Glassmorphism Utilities */
        .glass-card {
            background: rgba(22, 22, 21, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .spline-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            opacity: 0; /* GSAP will fade this in */
            transform: scale(1.05);
        }
        
        spline-viewer {
            width: 100%;
            height: 100%;
        }

        /* Hide Spline Logo */
        spline-viewer::part(logo) {
            display: none !important;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased text-[#EDEDEC] bg-[#0a0a0a] min-h-screen relative overflow-hidden flex items-stretch">
    
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-noise"></div>
    <div class="absolute top-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary-600/10 rounded-full blur-[120px] -z-10 pointer-events-none mix-blend-screen"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[30vw] h-[30vw] bg-amber-500/10 rounded-full blur-[100px] -z-10 pointer-events-none mix-blend-screen"></div>
    <div class="absolute top-[40%] right-[20%] w-[20vw] h-[20vw] bg-primary-400/5 rounded-full blur-[80px] -z-10 pointer-events-none"></div>

    <!-- Main Container Layout: 2 Columns Full Screen -->
    <div class="w-full h-screen flex flex-col lg:flex-row relative z-10">
        
        <!-- Left Side (Branding & 3D, ~45%) -->
        <div class="relative w-full lg:w-[45%] p-8 lg:p-14 flex flex-col justify-between overflow-hidden group hidden lg:flex bg-black/40 backdrop-blur-sm border-r border-white/5">
            
            <!-- 3D Spline Background -->
            <div class="spline-container gsap-spline">
                <!-- Using a premium abstract floating geometry from Spline with global events -->
                <spline-viewer url="https://prod.spline.design/6Wq1Q7YGyM-iab9i/scene.splinecode" events-target="global" loading-anim-type="spinner-small-dark"></spline-viewer>
                
                <!-- Overlay to blend 3D with background and text -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/60 to-transparent lg:bg-gradient-to-r lg:from-[#0a0a0a]/80 lg:via-transparent lg:to-[#0a0a0a] z-10 pointer-events-none"></div>
            </div>

            <!-- Content Over 3D -->
            <div class="relative z-20 flex-1 flex flex-col">
                <!-- Top Wrapper (Back Button + Logo) -->
                <div class="gsap-left-item mb-12 flex flex-col items-start gap-8">
                    <!-- Back Button -->
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-sm font-semibold text-gray-400 hover:text-white transition-all group backdrop-blur-md bg-white/5 p-2 pr-5 rounded-full border border-white/10 hover:border-white/20 shadow-lg w-max">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                        </div>
                        Kembali
                    </a>

                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group/logo cursor-pointer w-max">
                        <div class="relative flex items-center justify-center w-11 h-11 text-white rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 font-bold text-xl shadow-lg shadow-primary-500/30 overflow-hidden">
                            <span class="relative z-10">S</span>
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/logo:translate-y-0 transition-transform duration-300 ease-out"></div>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-white font-['Plus_Jakarta_Sans']">Servizz.io</span>
                    </a>
                </div>

                <!-- Spacer -->
                <div class="flex-1"></div>

                <!-- Text Content -->
                <div class="max-w-md">
                    <div class="gsap-left-item inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-primary-400 font-medium text-xs mb-6 backdrop-blur-sm">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        Next-Gen Service Management
                    </div>
                    
                    <h1 class="gsap-left-item text-4xl lg:text-5xl font-extrabold text-white leading-[1.15] mb-5 font-['Plus_Jakarta_Sans'] tracking-tight">
                        Kelola Bisnis Jasa <br> Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-amber-300">Eksklusif</span>
                    </h1>
                    
                    <p class="gsap-left-item text-gray-400 text-base leading-relaxed mb-8 font-['Inter']">
                        Tingkatkan produktivitas dan skala bisnis Anda dengan platform manajemen modern yang dirancang untuk performa dan keamanan enterprise.
                    </p>

                    <!-- Trust/Features -->
                    <div class="gsap-left-item flex items-center gap-6">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-[#0a0a0a] object-cover" src="https://i.pravatar.cc/100?img=33" alt="User 1">
                            <img class="w-10 h-10 rounded-full border-2 border-[#0a0a0a] object-cover" src="https://i.pravatar.cc/100?img=47" alt="User 2">
                            <img class="w-10 h-10 rounded-full border-2 border-[#0a0a0a] object-cover" src="https://i.pravatar.cc/100?img=12" alt="User 3">
                            <div class="w-10 h-10 rounded-full border-2 border-[#0a0a0a] bg-primary-600 flex items-center justify-center text-xs font-bold text-white z-10">+1k</div>
                        </div>
                        <div class="text-sm font-medium text-gray-300">
                            Dipercaya oleh <span class="text-white font-bold">1,000+</span> bisnis
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side (Form Panel, ~55%) -->
        <div class="w-full lg:w-[55%] h-full relative z-20 overflow-y-auto custom-scrollbar">
            <div class="min-h-full flex flex-col justify-center p-6 lg:p-12 xl:p-16">
                <!-- Glass Form Container -->
                <div class="w-full max-w-[480px] mx-auto glass-card rounded-3xl p-8 sm:p-10 relative overflow-hidden group/card transition-all duration-500 hover:shadow-primary-500/10">
                    
                    <!-- Inner Glow for Card -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-[1px] bg-gradient-to-r from-transparent via-primary-500/50 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-700"></div>

                <div class="text-center mb-8">
                    <h2 class="gsap-right-item text-3xl font-extrabold text-white mb-3 font-['Plus_Jakarta_Sans'] tracking-tight">
                        @yield('header_title', 'Welcome Back')
                    </h2>
                    <p class="gsap-right-item text-sm text-gray-400 font-['Inter']">
                        @yield('header_subtitle', 'Masukkan kredensial Anda untuk melanjutkan')
                    </p>
                </div>

                <!-- Alerts / Flash Messages -->
                <div class="gsap-right-item w-full">
                    @if(session('flash_message'))
                        @php $type = session('flash_type') === 'error' ? 'danger' : 'success'; @endphp
                        <x-alert :type="$type" :message="session('flash_message')" />
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium backdrop-blur-md flex gap-3 items-start shadow-[0_4px_16px_rgba(239,68,68,0.1)]">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm font-medium backdrop-blur-md flex gap-3 items-start shadow-[0_4px_16px_rgba(34,197,94,0.1)]">
                            <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 mt-0.5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium backdrop-blur-md flex gap-3 items-start shadow-[0_4px_16px_rgba(239,68,68,0.1)]">
                            <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Main Content (Form) -->
                <div class="gsap-right-item">
                    @yield('content')
                </div>
                
            </div>
            <!-- End Glass Form Container -->
            </div>
        </div>

    </div>

    <!-- Initialization Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Lucide Icons init if not already handled by app.js
            if(typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // GSAP Animations
            gsap.config({ nullTargetWarn: false });

            const tl = gsap.timeline();

            // Spline container fade & scale
            tl.to('.gsap-spline', {
                opacity: 1,
                scale: 1,
                duration: 1.5,
                ease: 'power3.out',
                onComplete: () => {
                    // Smooth continuous floating after entrance
                    gsap.to('.gsap-spline', {
                        y: -15,
                        duration: 3,
                        ease: "sine.inOut",
                        yoyo: true,
                        repeat: -1
                    });
                }
            }, 0.2);

            // Left panel text cascade
            tl.from('.gsap-left-item', {
                y: 30,
                opacity: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: 'power3.out'
            }, 0.4);

            // Right panel form elements cascade
            tl.from('.gsap-right-item', {
                y: 30,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out'
            }, 0.6);
        });
    </script>
</body>
</html>
