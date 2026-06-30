@props(['id', 'title' => 'Modal Title'])

<div 
    x-data="{ show: false }" 
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') { show = true; document.body.style.overflow = 'hidden'; }"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') { show = false; document.body.style.overflow = 'auto'; }"
    x-on:keydown.escape.window="show = false; document.body.style.overflow = 'auto';"
    x-show="show"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden"
    style="display: none;"
>
    <!-- Backdrop with blur -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
        x-on:click="show = false; document.body.style.overflow = 'auto';"
    ></div>

    <!-- Modal Panel -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative bg-surface dark:bg-[#161615] rounded-2xl shadow-xl dark:shadow-black/50 w-full max-w-lg mx-4 overflow-hidden transform transition-all border border-gray-100 dark:border-[#3E3E3A]"
    >
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#3E3E3A] flex items-center justify-between bg-gray-50/50 dark:bg-[#1f1f1e]">
            <h3 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] font-heading">{{ $title }}</h3>
            <button x-on:click="show = false; document.body.style.overflow = 'auto';" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#262625] p-1.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 text-gray-700 dark:text-gray-400">
            {{ $slot }}
        </div>
    </div>
</div>
