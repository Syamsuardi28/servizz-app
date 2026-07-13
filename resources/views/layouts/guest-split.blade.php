<!DOCTYPE html>
<html lang="id" class="dark overscroll-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') — Servizz.io</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
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
            
            <!-- Pure CSS/HTML Abstract Floating Geometry (Zero Lag, No Spline Watermark) -->
            <div class="spline-container gsap-spline flex items-center justify-center">
                
                <!-- Background Mesh Grid Overlay -->
                <div class="absolute inset-0 opacity-[0.07] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] pointer-events-none"></div>

                <!-- Ambient Radial Glow Core -->
                <div class="absolute w-[400px] h-[400px] rounded-full bg-gradient-to-br from-primary-500/20 to-amber-500/10 blur-[80px] pointer-events-none"></div>

                <div class="relative w-[360px] h-[360px] flex items-center justify-center">
                    
                    <style>
                        @keyframes slow-rotate {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                        @keyframes slow-float {
                            0%, 100% { transform: translateY(0px) rotate(-3deg); }
                            50% { transform: translateY(-12px) rotate(1deg); }
                        }
                        .animate-slow-rotate {
                            animation: slow-rotate 25s linear infinite;
                        }
                        .animate-slow-float {
                            animation: slow-float 6s ease-in-out infinite;
                        }
                    </style>

                    <!-- Glowing Orbit Ring -->
                    <div class="animate-slow-rotate absolute w-72 h-72 rounded-full border border-dashed border-white/10 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 rounded-full bg-primary-500 absolute -top-1 shadow-[0_0_10px_#F53003]"></div>
                        <div class="w-1 h-1 rounded-full bg-amber-400 absolute -bottom-0.5"></div>
                    </div>

                    <div class="animate-slow-rotate absolute w-56 h-56 rounded-full border border-white/[0.04]"></div>

                    <!-- Inner Frosted Glass Ring (Behind Card) -->
                    <div class="absolute w-48 h-48 rounded-full border border-white/5 bg-white/[0.01] backdrop-blur-md"></div>

                    <!-- Premium Glassmorphic Debit Card (Representing Servizz Core) -->
                    <div class="animate-slow-float absolute w-[260px] h-[162px] bg-gradient-to-br from-white/10 via-white/[0.02] to-transparent backdrop-blur-xl border border-white/15 rounded-2xl p-4 shadow-[0_30px_70px_rgba(0,0,0,0.5)] flex flex-col justify-between hover:border-primary-500/30 transition-colors duration-500">
                        <div class="flex justify-between items-start">
                            <!-- Smart Chip -->
                            <svg class="w-8 h-7 text-white/70 fill-current" viewBox="0 0 100 80">
                                <rect width="100" height="80" rx="15" fill="rgba(255,255,255,0.08)" />
                                <rect x="15" y="15" width="20" height="20" rx="5" />
                                <rect x="40" y="15" width="20" height="20" rx="5" />
                                <rect x="65" y="15" width="20" height="20" rx="5" />
                                <rect x="15" y="45" width="20" height="20" rx="5" />
                                <rect x="40" y="45" width="20" height="20" rx="5" />
                                <rect x="65" y="45" width="20" height="20" rx="5" />
                            </svg>
                            <span class="text-[8px] font-black tracking-widest text-primary-400 bg-primary-500/10 border border-primary-500/20 px-2 py-0.5 rounded-full">SECURE</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-[11px] font-mono tracking-widest text-white/80">**** **** **** 2026</p>
                            <div class="flex justify-between items-end mt-3">
                                <div>
                                    <p class="text-[6px] uppercase tracking-wider text-gray-500">Authorized User</p>
                                    <p class="text-[10px] font-bold text-gray-300">SERVIZZ MEMBER</p>
                                </div>
                                <div class="flex -space-x-1.5 opacity-80">
                                    <div class="w-4 h-4 rounded-full bg-primary-500"></div>
                                    <div class="w-4 h-4 rounded-full bg-amber-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Info-Widgets -->
                    <div class="absolute top-2 -right-6 bg-white/5 border border-white/10 backdrop-blur-md rounded-xl px-3 py-2 shadow-lg text-white flex items-center gap-1.5 animate-bounce" style="animation-duration: 3.5s;">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-primary-500"></i>
                        <span class="text-[8px] font-black tracking-wider uppercase text-gray-300">Sistem Aman</span>
                    </div>

                    <div class="absolute bottom-4 -left-8 bg-white/5 border border-white/10 backdrop-blur-md rounded-xl px-3 py-2 shadow-lg text-white flex items-center gap-1.5 animate-bounce" style="animation-duration: 4s;">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                        <span class="text-[8px] font-black tracking-wider uppercase text-gray-300">Skala Enterprise</span>
                    </div>

                </div>

                <!-- Overlay to blend with background and text -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/60 to-transparent lg:bg-gradient-to-r lg:from-[#0a0a0a]/80 lg:via-transparent lg:to-[#0a0a0a] z-10 pointer-events-none"></div>
            </div>

            <!-- Content Over 3D -->
            <div class="relative z-20 flex-1 flex flex-col">
                <!-- Top Wrapper (Back Button & Logo aligned horizontally) -->
                <div class="gsap-left-item mb-12 flex flex-row justify-between items-center w-full">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group/logo cursor-pointer w-max">
                        <div class="relative flex items-center justify-center w-11 h-11 text-white rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 font-bold text-xl shadow-lg shadow-primary-500/30 overflow-hidden">
                            <span class="relative z-10">S</span>
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/logo:translate-y-0 transition-transform duration-300 ease-out"></div>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-white font-['Plus_Jakarta_Sans']">Servizz.io</span>
                    </a>

                    <!-- Back Button -->
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-sm font-semibold text-gray-400 hover:text-white transition-all group backdrop-blur-md bg-white/5 p-2 pr-5 rounded-full border border-white/10 hover:border-white/20 shadow-lg w-max">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
                        </div>
                        Kembali
                    </a>
                </div>

                <!-- Spacer -->
                <div class="flex-1"></div>

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
                        <x-alert type="danger" :message="session('error')" />
                    @endif
                    
                    @if(session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if($errors->any())
                        <x-alert type="danger" :messages="$errors->all()" />
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
