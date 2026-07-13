@props(['type' => 'info', 'message' => null, 'messages' => null])

@php
    $variants = [
        'success' => [
            'wrapper' => 'bg-white/95 dark:bg-[#161615]/95 border-emerald-500/50 text-gray-900 dark:text-[#EDEDEC] shadow-[0_15px_30px_rgba(16,185,129,0.15)]',
            'icon' => 'check-circle-2',
            'iconColor' => 'text-emerald-500',
            'progressBar' => 'bg-emerald-500'
        ],
        'danger' => [
            'wrapper' => 'bg-white/95 dark:bg-[#161615]/95 border-red-500/50 text-gray-900 dark:text-[#EDEDEC] shadow-[0_15px_30px_rgba(239,68,68,0.15)]',
            'icon' => 'x-circle',
            'iconColor' => 'text-red-500',
            'progressBar' => 'bg-red-500'
        ],
        'warning' => [
            'wrapper' => 'bg-white/95 dark:bg-[#161615]/95 border-amber-500/50 text-gray-900 dark:text-[#EDEDEC] shadow-[0_15px_30px_rgba(245,158,11,0.15)]',
            'icon' => 'alert-triangle',
            'iconColor' => 'text-amber-500',
            'progressBar' => 'bg-amber-500'
        ],
        'info' => [
            'wrapper' => 'bg-white/95 dark:bg-[#161615]/95 border-[#F53003]/50 text-gray-900 dark:text-[#EDEDEC] shadow-[0_15px_30px_rgba(245,48,3,0.15)]',
            'icon' => 'info',
            'iconColor' => 'text-[#F53003]',
            'progressBar' => 'bg-[#F53003]'
        ],
    ];

    $style = $variants[$type] ?? $variants['info'];
@endphp

<div x-data="{ show: true, progress: 100 }"
     x-show="show"
     x-init="
        setTimeout(() => show = false, 5000);
        let interval = setInterval(() => { progress -= 0.8; if(progress <= 0) clearInterval(interval); }, 40);
     "
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
     class="fixed bottom-6 right-6 z-[100] overflow-hidden rounded-2xl border border-white/10 dark:border-white/5 backdrop-blur-xl border-l-4 {{ $style['wrapper'] }} min-w-[320px] max-w-sm"
     style="display: none;">
    
    <div class="flex items-start gap-4 p-5">
        <div class="shrink-0 mt-0.5">
            <i data-lucide="{{ $style['icon'] }}" class="w-5 h-5 {{ $style['iconColor'] }}"></i>
        </div>
        
        <div class="flex-1 flex flex-col min-w-0">
            @if($message)
                <span class="font-bold text-sm leading-snug">{{ $message }}</span>
            @endif

            @if($messages)
                <div class="flex flex-col">
                    <span class="font-bold text-sm leading-snug mb-1.5">Terjadi kesalahan:</span>
                    <ul class="list-disc list-inside space-y-1 text-xs text-gray-500 dark:text-gray-400">
                        @foreach($messages as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <button @click="show = false" class="shrink-0 opacity-40 hover:opacity-100 transition-opacity p-0.5 -mt-0.5">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Progress Bar -->
    <div class="h-[3px] w-full bg-black/5 dark:bg-white/5 absolute bottom-0 left-0">
        <div class="h-full {{ $style['progressBar'] }} transition-all duration-75 ease-linear" :style="`width: ${progress}%`"></div>
    </div>
</div>
