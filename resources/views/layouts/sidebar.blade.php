<!-- Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 bg-surface dark:bg-[#161615] border-r border-gray-100 dark:border-[#3E3E3A] transition-transform duration-300 lg:translate-x-0 lg:static"
    :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }"
>
    <!-- Brand -->
    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 dark:border-[#3E3E3A]">
        <div class="flex items-center justify-center w-8 h-8 text-white rounded-lg bg-primary-500 shadow-md shadow-primary-500/20 font-heading font-bold">
            S
        </div>
        <span class="text-xl font-heading font-bold tracking-tight text-gray-900 dark:text-[#EDEDEC]">Servizz.io</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto overscroll-none">
        
        @if(session('servizz_user.role') === 'Admin')
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('dashboard') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Dashboard
        </a>
        @endif

        <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('orders.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="shopping-bag" class="w-5 h-5 {{ request()->routeIs('orders.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Pesanan
        </a>

        @if(session('servizz_user.role') === 'Admin')
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</p>
        </div>

        <a href="{{ route('technicians.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('technicians.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('technicians.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Mitra / Teknisi
        </a>

        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="user-circle" class="w-5 h-5 {{ request()->routeIs('users.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Pengguna
        </a>
        @endif
        
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan</p>
        </div>

        <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('services.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="briefcase" class="w-5 h-5 {{ request()->routeIs('services.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Kategori Jasa
        </a>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-gray-100 dark:border-[#3E3E3A] space-y-1">
        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('settings.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="settings" class="w-5 h-5 {{ request()->routeIs('settings.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Pengaturan
        </a>
        @if(session('servizz_user.role') !== 'Admin')
        <a href="{{ route('help.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('help.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-[#262625] hover:text-gray-900 dark:hover:text-[#EDEDEC]' }}">
            <i data-lucide="help-circle" class="w-5 h-5 {{ request()->routeIs('help.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
            Bantuan
        </a>
        @endif

        <div class="pt-2">
            <a href="{{ route('profile.index') }}" class="flex items-center gap-3 p-2 mt-2 rounded-xl hover:bg-gray-50 dark:hover:bg-[#262625] transition-colors border border-transparent hover:border-gray-200 dark:hover:border-[#3E3E3A]">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 font-bold">
                    {{ strtoupper(substr(session('servizz_user.nama', 'U'), 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-[#EDEDEC] truncate">{{ session('servizz_user.nama', 'User') }}</p>
                    <p class="text-xs font-medium text-gray-500 truncate">{{ session('servizz_user.role', 'Pelanggan') }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
            </a>
        </div>
    </div>
</aside>
