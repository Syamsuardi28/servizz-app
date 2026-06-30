@props(['type' => 'info', 'message'])

@php
    $variants = [
        'success' => [
            'wrapper' => 'bg-white dark:bg-[#1a1a1a] border-emerald-500 text-gray-800 dark:text-gray-200',
            'icon' => 'check-circle-2',
            'iconColor' => 'text-emerald-500',
            'progressBar' => 'bg-emerald-500'
        ],
        'danger' => [
            'wrapper' => 'bg-white dark:bg-[#1a1a1a] border-red-500 text-gray-800 dark:text-gray-200',
            'icon' => 'x-circle',
            'iconColor' => 'text-red-500',
            'progressBar' => 'bg-red-500'
        ],
        'warning' => [
            'wrapper' => 'bg-white dark:bg-[#1a1a1a] border-amber-500 text-gray-800 dark:text-gray-200',
            'icon' => 'alert-triangle',
            'iconColor' => 'text-amber-500',
            'progressBar' => 'bg-amber-500'
        ],
        'info' => [
            'wrapper' => 'bg-white dark:bg-[#1a1a1a] border-blue-500 text-gray-800 dark:text-gray-200',
            'icon' => 'info',
            'iconColor' => 'text-blue-500',
            'progressBar' => 'bg-blue-500'
        ],
    ];

    $style = $variants[$type] ?? $variants['info'];
@endphp

<div x-data="{ show: true, progress: 100 }"
     x-show="show"
     x-init="
        setTimeout(() => show = false, 4000);
        let interval = setInterval(() => { progress -= 1; if(progress <= 0) clearInterval(interval); }, 40);
     "
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-10"
     x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 sm:translate-x-0"
     x-transition:leave-end="opacity-0 sm:translate-x-10 translate-y-4"
     class="fixed bottom-6 right-6 z-[100] overflow-hidden rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] border-l-4 {{ $style['wrapper'] }} min-w-[300px] max-w-sm"
     style="display: none;">
    
    <div class="flex items-center gap-3 p-4">
        <i data-lucide="{{ $style['icon'] }}" class="w-6 h-6 shrink-0 {{ $style['iconColor'] }}"></i>
        <span class="font-medium text-sm leading-snug">{{ $message }}</span>
        <button @click="show = false" class="ml-auto shrink-0 opacity-50 hover:opacity-100 transition-opacity p-1">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Progress Bar -->
    <div class="h-1 w-full bg-gray-100 dark:bg-gray-800 absolute bottom-0 left-0">
        <div class="h-full {{ $style['progressBar'] }} transition-all duration-75 ease-linear" :style="`width: ${progress}%`"></div>
    </div>
</div>
