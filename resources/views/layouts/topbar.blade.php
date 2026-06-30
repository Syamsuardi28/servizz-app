<!-- Topbar -->
<header class="shrink-0 z-30 flex items-center justify-between h-16 px-4 bg-white dark:bg-[#0a0a0a] border-b border-gray-100 dark:border-[#3E3E3A] sm:px-6">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button 
            @click="isSidebarOpen = true" 
            class="p-2 text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500"
        >
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] hidden sm:block">@yield('breadcrumb', 'Dashboard')</h1>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 hidden sm:block">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM Y') }}</p>
        </div>
    </div>

    <div class="flex items-center gap-3 sm:gap-4">
        <!-- Search Button & Modal -->
        <!-- Search Button & Modal -->
        <div x-data="{ 
            searchOpen: false,
            query: '',
            items: [
                { name: 'Dashboard', url: '{{ route('home') }}', icon: 'home', desc: 'Ringkasan dan statistik sistem' },
                { name: 'Data Pesanan', url: '{{ route('orders.index') ?? '#' }}', icon: 'shopping-cart', desc: 'Kelola semua pesanan pelanggan' },
                { name: 'Data Pengguna', url: '{{ route('users.index') ?? '#' }}', icon: 'users', desc: 'Kelola akun pelanggan & teknisi' },
                { name: 'Data Teknisi', url: '{{ route('technicians.index') ?? '#' }}', icon: 'wrench', desc: 'Kelola pendaftaran teknisi' },
                { name: 'Data Layanan', url: '{{ route('services.index') ?? '#' }}', icon: 'briefcase', desc: 'Kategori layanan jasa' },
                { name: 'Profil Saya', url: '{{ route('settings.index') }}', icon: 'user', desc: 'Ubah foto profil & informasi dasar' },
                { name: 'Pengaturan Sandi', url: '{{ route('settings.password') }}', icon: 'lock', desc: 'Ubah kata sandi akun Anda' },
                { name: 'Pengaturan Notifikasi', url: '{{ route('settings.notifications') }}', icon: 'bell', desc: 'Atur preferensi notifikasi' },
                { name: 'Verifikasi Akun', url: '{{ route('settings.verification') }}', icon: 'shield-check', desc: 'Verifikasi dokumen identitas' },
                { name: 'Bantuan & Dukungan', url: '{{ route('help.index') ?? '#' }}', icon: 'help-circle', desc: 'Pusat bantuan & FAQ' }
            ],
            get filteredItems() {
                if (this.query.trim() === '') return [];
                return this.items.filter(item => 
                    item.name.toLowerCase().includes(this.query.toLowerCase()) || 
                    item.desc.toLowerCase().includes(this.query.toLowerCase())
                );
            }
        }" 
        x-init="$watch('query', () => { $nextTick(() => { if(window.lucide) { window.lucide.createIcons(); } }) })"
        @keydown.window.ctrl.k.prevent="searchOpen = true" 
        @keydown.window.meta.k.prevent="searchOpen = true" 
        @keydown.window.escape="searchOpen = false">
            <button @click="searchOpen = true" class="p-2 text-gray-400 rounded-full hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-[#262625] transition-colors" title="Pencarian (Ctrl+K)">
                <i data-lucide="search" class="w-5 h-5"></i>
            </button>

            <!-- Search Modal Overlay -->
            <div x-show="searchOpen" class="fixed inset-0 z-[100] flex items-start justify-center pt-20 px-4" style="display: none;" x-cloak>
                
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                     @click="searchOpen = false" 
                     x-show="searchOpen" 
                     x-transition.opacity></div>
                
                <!-- Modal Content -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-2xl border border-gray-100 dark:border-[#3E3E3A] w-full max-w-2xl overflow-hidden relative z-10" 
                     x-show="searchOpen" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 scale-95" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-100" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-95" 
                     @click.stop>
                     
                    <!-- Search Input Area -->
                    <div class="flex items-center px-4 border-b border-gray-100 dark:border-[#3E3E3A]">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400 shrink-0"></i>
                        <input type="text" 
                               x-model="query"
                               class="flex-1 px-4 py-4 bg-transparent border-none focus:ring-0 text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 text-base outline-none" 
                               placeholder="Cari pesanan, pengguna, atau fitur..." 
                               x-trap.noscroll="searchOpen">
                        <button @click="searchOpen = false; query = ''" class="text-xs font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-[#262625] border border-gray-200 dark:border-[#3E3E3A] px-2 py-1 rounded-md shrink-0 transition-colors hover:bg-gray-200 dark:hover:bg-[#3E3E3A]">
                            ESC
                        </button>
                    </div>

                    <!-- Search Results Placeholder / Empty State -->
                    <div x-show="query.trim() === ''" class="p-4 py-16 text-center bg-gray-50/50 dark:bg-[#161615]">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-[#20201f] text-gray-400 mb-4">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-base font-bold text-gray-900 dark:text-[#EDEDEC] mb-1">Pencarian Cepat</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Ketikkan sesuatu untuk mencari fitur, pengguna, pesanan, atau halaman pengaturan.</p>
                    </div>

                    <!-- Search Results Area -->
                    <div x-show="query.trim() !== ''" class="p-2 max-h-[400px] overflow-y-auto bg-white dark:bg-[#161615]" style="display: none;">
                        
                        <!-- List Results -->
                        <div class="space-y-1">
                            <template x-for="item in filteredItems" :key="item.name">
                                <a :href="item.url" class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-[#20201f] transition-colors border border-transparent hover:border-gray-100 dark:hover:border-[#3E3E3A] group">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-[#262625] flex items-center justify-center text-gray-500 dark:text-gray-400 group-hover:text-primary-500 group-hover:bg-primary-50 dark:group-hover:bg-primary-900/20 transition-colors shrink-0">
                                        <i :data-lucide="item.icon" class="w-5 h-5"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]" x-text="item.name"></h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="item.desc"></p>
                                    </div>
                                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </a>
                            </template>
                        </div>

                        <!-- No Results -->
                        <div x-show="filteredItems.length === 0" class="py-12 text-center text-gray-500 dark:text-gray-400" style="display: none;">
                            <p class="text-sm">Tidak ada hasil yang cocok untuk "<span class="font-bold text-gray-900 dark:text-[#EDEDEC]" x-text="query"></span>".</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="relative p-2 text-gray-400 rounded-full hover:text-gray-500 hover:bg-gray-100 transition-colors">
                <i data-lucide="bell" class="w-5 h-5"></i>
                @if(($adminUnreadCount ?? 0) > 0)
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                @endif
            </button>

            <!-- Dropdown -->
            <div x-show="open" x-transition.opacity class="absolute right-0 mt-2 w-80 bg-white dark:bg-[#161615] rounded-2xl shadow-xl dark:shadow-black/50 border border-gray-100 dark:border-[#3E3E3A] overflow-hidden z-50" style="display: none;">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-[#3E3E3A] flex justify-between items-center bg-gray-50/50 dark:bg-[#1f1f1e]">
                    <span class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC]">Notifikasi</span>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @if(isset($adminNotifications) && count($adminNotifications) > 0)
                        @foreach($adminNotifications as $notif)
                            <div class="px-4 py-3 border-b border-gray-50 dark:border-[#3E3E3A]/50 {{ $notif['is_read'] ? 'bg-white dark:bg-[#161615]' : 'bg-primary-50/30 dark:bg-primary-900/10' }}">
                                <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC] mb-1">{{ $notif['judul'] }}</p>
                                <p class="text-xs text-gray-500 mb-2">{{ $notif['pesan'] }}</p>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400">{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</span>
                                    @if(!$notif['is_read'])
                                        <button onclick="markNotifRead({{ $notif['id_notif'] }})" class="font-semibold text-primary-500 hover:text-primary-600">Tandai dibaca</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="px-4 py-8 text-center">
                            <i data-lucide="bell-off" class="w-8 h-8 mx-auto text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Tidak ada notifikasi baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="flex items-center gap-2 p-1 pl-2 pr-3 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-full hover:bg-gray-50 dark:hover:bg-[#262625] transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(session('servizz_user.nama', 'A'), 0, 2)) }}
                </div>
                <span class="text-sm font-semibold text-gray-700 dark:text-[#EDEDEC] hidden sm:block">
                    {{ explode(' ', session('servizz_user.nama', 'Admin'))[0] }}
                </span>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <!-- Dropdown -->
            <div x-show="open" x-transition.opacity class="absolute right-0 mt-2 w-56 bg-white dark:bg-[#161615] rounded-2xl shadow-xl dark:shadow-black/50 border border-gray-100 dark:border-[#3E3E3A] overflow-hidden z-50" style="display: none;">
                <div class="px-4 py-4 border-b border-gray-100 dark:border-[#3E3E3A] flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(session('servizz_user.nama', 'A'), 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] leading-tight">{{ session('servizz_user.nama', 'Administrator') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ session('servizz_user.role', 'User') }}</p>
                    </div>
                </div>
                <div class="p-2 space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Lihat Profil
                    </a>
                </div>
                <div class="p-2 border-t border-gray-100 dark:border-[#3E3E3A]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full gap-2 px-3 py-2 text-sm font-medium text-red-600 dark:text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
