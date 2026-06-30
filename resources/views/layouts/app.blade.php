<!DOCTYPE html>
<html lang="id" class="dark overscroll-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Servizz.io</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-background text-gray-900 dark:bg-[#0a0a0a] dark:text-[#EDEDEC] font-sans antialiased overflow-x-hidden overscroll-none">
    
    <div x-data="{ isSidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="isSidebarOpen" 
            x-transition.opacity 
            class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden backdrop-blur-sm"
            @click="isSidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Wrapper -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">
            
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto overscroll-none p-4 sm:p-6 lg:p-8 bg-background dark:bg-[#0a0a0a]">
                
                <!-- Flash Messages -->
                @if(session('flash_message'))
                    @php $type = session('flash_type') === 'error' ? 'danger' : 'success'; @endphp
                    <x-alert :type="$type" :message="session('flash_message')" />
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium">
                        <div class="flex gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="max-w-7xl mx-auto space-y-6">
                    @yield('content')
                </div>

            </main>
        </div>
    </div>

    <script>
        function markNotifRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(res => res.json()).then(data => {
                if(data.success || data.message) {
                    window.location.reload();
                }
            }).catch(console.error);
        }
    </script>
    @yield('scripts')
</body>
</html>
