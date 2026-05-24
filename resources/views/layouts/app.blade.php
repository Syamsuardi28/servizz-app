{{-- Lokasi: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SERVIZZ Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/css/servizz.css', 'resources/css/layout.css', 'resources/js/servizz.js'])
    @stack('styles')
    <style>
        /* Sidebar Footer & User Widget Bypass Cache */
        .svz-sidebar-footer {
            padding: 0 20px;
            margin-top: 20px;
        }

        .sidebar-user-widget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--svz-surf);
            border: 1px solid var(--svz-border);
            border-radius: 20px;
            padding: 10px 14px;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            transition: all 0.2s;
        }

        .sidebar-user-widget:hover {
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            transform: translateY(-2px);
            border-color: #e2e8f0;
        }

        .sidebar-user-widget-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d6ccff 0%, #b8acf0 100%);
            color: var(--svz-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-user-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-user-text .name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--svz-txt);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 90px;
        }

        .sidebar-user-text .email {
            font-size: 11px;
            color: var(--svz-muted);
            font-weight: 500;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 90px;
        }

        .sidebar-user-action {
            color: var(--svz-muted);
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f8fafc;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        .sidebar-user-widget:hover .sidebar-user-action {
            background: var(--svz-primary-bg);
            color: var(--svz-primary);
            transform: translateX(4px);
        }
    </style>
</head>

<body>
    <div class="svz-shell">
        {{-- ── Sidebar ── --}}
        <aside class="svz-sidebar" id="sidebar">
            <div class="svz-sidebar-brand">
                <div class="svz-logo-mark">S</div>
                <div class="svz-brand-name">Servizz.io</div>
            </div>

            <nav class="svz-nav">
                @if(session('servizz_user.role') === 'Admin')
                    <a href="{{ route('dashboard') }}" class="svz-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                @endif
                
                <a href="{{ route('orders.index') }}" class="svz-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i>
                    <span>Pesanan</span>
                </a>
                

                
                @if(session('servizz_user.role') === 'Admin')
                    <a href="{{ route('technicians.index') }}" class="svz-nav-item {{ request()->routeIs('technicians.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Mitra / Teknisi</span>
                    </a>
                    
                    <a href="{{ route('users.index') }}" class="svz-nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengguna</span>
                    </a>
                @endif
                
                <a href="{{ route('services.index') }}" class="svz-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Kategori Jasa</span>
                </a>
            </nav>

            <div class="svz-sidebar-footer">
                <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px;">
                    <a href="{{ route('settings.index') }}" class="svz-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                    @if(session('servizz_user.role') !== 'Admin')
                    <a href="{{ route('help.index') }}" class="svz-nav-item {{ request()->routeIs('help.*') ? 'active' : '' }}">
                        <i class="bi bi-headset"></i>
                        <span>Bantuan</span>
                    </a>
                    @endif
                </div>

                <a href="{{ route('profile.index') }}" class="sidebar-user-widget">
                    <div class="sidebar-user-widget-info">
                        <div class="sidebar-user-avatar">
                            @if(session('servizz_user.foto_profil'))
                                <img src="{{ env('SERVIZZ_API_URL', 'http://localhost:3000') }}/uploads/avatars/{{ session('servizz_user.foto_profil') }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                            @else
                                {{ strtoupper(substr(session('servizz_user.nama', 'U'), 0, 1)) }}
                            @endif
                        </div>
                        <div class="sidebar-user-text">
                            <span class="name">{{ session('servizz_user.nama', 'User') }}</span>
                            <span class="email">{{ session('servizz_user.role', 'Pelanggan') }}</span>
                        </div>
                    </div>
                    <div class="sidebar-user-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>
            </div>
        </aside>

        {{-- ── Mobile Overlay ── --}}
        <div class="svz-overlay" id="overlay" onclick="closeSidebar()"></div>

        {{-- ── Main Content Area ── --}}
        <div class="svz-main">
            {{-- ── Topbar ── --}}
            <header class="svz-topbar">
                <div class="svz-topbar-left">
                    <button class="svz-sidebar-toggle" onclick="openSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h1 style="margin:0; font-size: 20px; font-weight: 800; color: var(--svz-txt);">@yield('breadcrumb', 'Dashboard')</h1>
                        <div class="topbar-date">
                            <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd') }}</span>, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM Y') }}
                        </div>
                    </div>
                </div>

                <div class="svz-topbar-right">
                    {{-- ── Message Dropdown ── --}}
                    <div style="position:relative;" id="svzMsgWrapper">
                        <button type="button" class="topbar-icon" id="svzMsgBtn" onclick="svzToggleMsgDropdown()" style="background:transparent; border:none; cursor:pointer;">
                            <i class="bi bi-envelope"></i>
                        </button>
                        <div id="svzMsgDropdown" style="display:none; position:absolute; top:calc(100% + 10px); right:-20px; background:#fff; border:1px solid #f1f5f9; border-radius:12px; width:280px; box-shadow:0 12px 35px rgba(0,0,0,0.1); z-index:99999; overflow:hidden;">
                            <div style="padding:14px 16px; border-bottom:1px solid #f1f5f9; font-weight:700; color:#1e293b; font-size:14px; display:flex; justify-content:space-between; align-items:center;">
                                Pesan Masuk
                                <span style="font-size:11px; font-weight:600; color:#3b82f6; cursor:pointer;">Tandai dibaca</span>
                            </div>
                            <div style="padding:40px 20px; text-align:center; color:#64748b; font-size:13px;">
                                <i class="bi bi-envelope-paper" style="font-size:28px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                                Belum ada pesan baru untuk Anda.
                            </div>
                        </div>
                    </div>

                    {{-- ── Notification Dropdown ── --}}
                    <div style="position:relative;" id="svzNotifWrapper">
                        <button type="button" class="topbar-icon" id="svzNotifBtn" onclick="svzToggleNotifDropdown()" style="background:transparent; border:none; cursor:pointer;">
                            <i class="bi bi-bell"></i>
                            @if(($adminUnreadCount ?? 0) > 0)
                                <span style="position:absolute; top:6px; right:8px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                            @endif
                        </button>
                        <div id="svzNotifDropdown" style="display:none; position:absolute; top:calc(100% + 10px); right:-10px; background:#fff; border:1px solid #f1f5f9; border-radius:12px; width:320px; box-shadow:0 12px 35px rgba(0,0,0,0.1); z-index:99999; overflow:hidden;">
                            <div style="padding:14px 16px; border-bottom:1px solid #f1f5f9; font-weight:700; color:#1e293b; font-size:14px; display:flex; justify-content:space-between; align-items:center;">
                                Notifikasi
                            </div>
                            <div style="max-height: 350px; overflow-y: auto;">
                                @if(isset($adminNotifications) && count($adminNotifications) > 0)
                                    @foreach($adminNotifications as $notif)
                                        <div style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9; background: {{ $notif['is_read'] ? '#ffffff' : '#f8fafc' }};">
                                            <div style="font-size: 13px; font-weight: 700; color: var(--svz-txt); margin-bottom: 4px;">{{ $notif['judul'] }}</div>
                                            <div style="font-size: 12px; color: var(--svz-muted); margin-bottom: 8px;">{{ $notif['pesan'] }}</div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <div style="font-size: 11px; color: #94a3b8;">{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</div>
                                                @if(!$notif['is_read'])
                                                    <button onclick="markNotifRead({{ $notif['id_notif'] }})" style="background: none; border: none; color: var(--svz-primary); font-size: 11px; font-weight: 600; cursor: pointer; padding: 0;">Tandai dibaca</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div style="padding:40px 20px; text-align:center; color:#64748b; font-size:13px;">
                                        <i class="bi bi-bell-slash" style="font-size:28px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                                        Anda belum memiliki notifikasi baru.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ── User Button + Dropdown ── --}}
                    <div style="position:relative;" id="svzUserWrapper">

                        {{-- Trigger Button --}}
                        <button
                            type="button"
                            id="svzUserBtn"
                            onclick="svzToggleDropdown()"
                            style="
                                display:flex; align-items:center; gap:10px;
                                background:transparent; border:none; cursor:pointer;
                                padding:6px 8px; border-radius:10px;
                                font-family:inherit; transition:background .15s;
                            "
                            onmouseenter="this.style.background='#f1f5f9'"
                            onmouseleave="this.style.background='transparent'"
                        >
                            {{-- Avatar --}}
                            <div style="
                                width:36px; height:36px; border-radius:8px;
                                background:#d6ccff; color:#4e488d;
                                display:flex; align-items:center; justify-content:center;
                                font-weight:800; font-size:13px; flex-shrink:0;
                            ">
                                {{ strtoupper(substr(session('servizz_user.nama', 'A'), 0, 2)) }}
                            </div>
                            {{-- Name --}}
                            <span style="font-weight:700; font-size:13.5px; color:#1a1a1a; white-space:nowrap;">
                                {{ explode(' ', session('servizz_user.nama', 'Admin'))[0] }}
                            </span>
                            <i class="bi bi-chevron-down" id="svzChevron" style="font-size:10px; color:#94a3b8; transition:transform .2s;"></i>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div
                            id="svzDropdown"
                            style="
                                display:none;
                                position:absolute; top:calc(100% + 10px); right:0;
                                background:#fff; border:1px solid #f1f5f9;
                                border-radius:16px; min-width:240px;
                                box-shadow:0 12px 40px rgba(0,0,0,0.13);
                                z-index:99999; overflow:hidden;
                            "
                        >
                            {{-- User Info Header --}}
                            <div style="display:flex; align-items:center; gap:12px; padding:18px 18px 14px;">
                                <div style="
                                    width:44px; height:44px; border-radius:12px;
                                    background:linear-gradient(135deg,#d6ccff,#b8acf0);
                                    color:#4e488d; display:flex; align-items:center;
                                    justify-content:center; font-weight:800; font-size:16px; flex-shrink:0;
                                ">
                                    {{ strtoupper(substr(session('servizz_user.nama', 'A'), 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-size:14px; font-weight:700; color:#1a1a1a; line-height:1.3;">
                                        {{ session('servizz_user.nama', 'Administrator') }}
                                    </div>
                                    <div style="font-size:11.5px; color:#94a3b8; font-weight:500; margin-top:2px;">
                                        {{ session('servizz_user.role', 'User') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div style="height:1px; background:#f1f5f9; margin:0 18px;"></div>

                            {{-- Profil & Settings Links --}}
                            <div style="padding:10px 10px 0 10px;">
                                <a href="{{ route('settings.index') }}"
                                   style="
                                       display:flex; align-items:center; gap:10px;
                                       width:100%; padding:10px 14px;
                                       background:transparent; border:none;
                                       border-radius:10px; cursor:pointer;
                                       text-decoration:none; font-size:13.5px;
                                       font-weight:600; color:#334155;
                                       transition:background .15s, color .15s;
                                   "
                                   onmouseenter="this.style.background='#f8fafc'; this.style.color='#1d4ed8'"
                                   onmouseleave="this.style.background='transparent'; this.style.color='#334155'"
                                >
                                    <i class="bi bi-person-fill"></i> Lihat Profil
                                </a>
                            </div>

                            {{-- Logout Button --}}
                            <div style="padding:4px 10px 10px 10px;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        style="
                                            display:flex; align-items:center; gap:10px;
                                            width:100%; padding:10px 14px;
                                            background:transparent; border:none;
                                            border-radius:10px; cursor:pointer;
                                            font-family:inherit; font-size:13.5px;
                                            font-weight:600; color:#ef4444;
                                            transition:background .15s, color .15s;
                                            text-align:left;
                                        "
                                        onmouseenter="this.style.background='#fef2f2'; this.style.color='#dc2626';"
                                        onmouseleave="this.style.background='transparent'; this.style.color='#ef4444';"
                                    >
                                        <i class="bi bi-box-arrow-right" style="font-size:17px;"></i>
                                        <span>Keluar / Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            {{-- ── Page Content ── --}}
            <main class="svz-content" style="padding-top: 30px;">
                {{-- Flash Messages --}}
                @if(session('flash_message'))
                    @if(session('flash_type') === 'error')
                        <div style="background:#fef2f2; color:#991b1b; padding:12px 20px; border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
                            <i class="bi bi-x-circle-fill"></i>
                            {{ session('flash_message') }}
                        </div>
                    @else
                        <div style="background:#ecfdf5; color:#166534; padding:12px 20px; border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ session('flash_message') }}
                        </div>
                    @endif
                @endif

                @if($errors->any())
                    <div style="background:#fef2f2; color:#991b1b; padding:12px 20px; border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
                        <i class="bi bi-x-circle-fill"></i>
                        <ul style="margin:0; padding-left:20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('overlay').classList.add('show');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').classList.remove('show');
        }

        function svzToggleMsgDropdown() {
            const dropdown = document.getElementById('svzMsgDropdown');
            const isOpen = dropdown.style.display === 'block';
            
            // Tutup dropdown lain
            document.getElementById('svzNotifDropdown').style.display = 'none';
            document.getElementById('svzDropdown').style.display = 'none';
            document.getElementById('svzChevron').style.transform = 'rotate(0deg)';

            dropdown.style.display = isOpen ? 'none' : 'block';
        }

        function svzToggleNotifDropdown() {
            const dropdown = document.getElementById('svzNotifDropdown');
            const isOpen = dropdown.style.display === 'block';
            
            // Tutup dropdown lain
            document.getElementById('svzMsgDropdown').style.display = 'none';
            document.getElementById('svzDropdown').style.display = 'none';
            document.getElementById('svzChevron').style.transform = 'rotate(0deg)';

            dropdown.style.display = isOpen ? 'none' : 'block';
        }

        function svzToggleDropdown() {
            const dropdown = document.getElementById('svzDropdown');
            const chevron  = document.getElementById('svzChevron');
            const isOpen   = dropdown.style.display === 'block';

            // Tutup dropdown lain
            document.getElementById('svzMsgDropdown').style.display = 'none';
            document.getElementById('svzNotifDropdown').style.display = 'none';

            if (isOpen) {
                dropdown.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            } else {
                dropdown.style.display = 'block';
                chevron.style.transform = 'rotate(180deg)';
            }
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            const userWrapper  = document.getElementById('svzUserWrapper');
            const userDropdown = document.getElementById('svzDropdown');
            const chevron  = document.getElementById('svzChevron');
            
            const msgWrapper = document.getElementById('svzMsgWrapper');
            const msgDropdown = document.getElementById('svzMsgDropdown');
            
            const notifWrapper = document.getElementById('svzNotifWrapper');
            const notifDropdown = document.getElementById('svzNotifDropdown');

            if (userWrapper && !userWrapper.contains(e.target)) {
                if (userDropdown) userDropdown.style.display = 'none';
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
            if (msgWrapper && !msgWrapper.contains(e.target)) {
                if (msgDropdown) msgDropdown.style.display = 'none';
            }
            if (notifWrapper && !notifWrapper.contains(e.target)) {
                if (notifDropdown) notifDropdown.style.display = 'none';
            }
        });

        function markNotifRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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