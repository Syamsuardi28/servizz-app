@props(['variant' => 'primary', 'type' => 'button', 'icon' => null, 'loading' => false])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary-500 text-white shadow-lg shadow-primary-500/30 hover:bg-primary-600 hover:shadow-primary-500/40 hover:-translate-y-0.5 focus:ring-primary-500',
        'secondary' => 'bg-white text-gray-700 border border-gray-200 dark:bg-[#161615] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:bg-[#262625] dark:hover:border-[#62605b] shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:ring-gray-200',
        'ghost' => 'bg-transparent text-gray-600 dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#262625] hover:text-gray-900 focus:ring-gray-200',
        'danger' => 'bg-red-500 text-white shadow-lg shadow-red-500/30 hover:bg-red-600 focus:ring-red-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($loading) disabled @endif>
    @if($loading)
        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
    @elseif($icon)
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    @endif
    
    {{ $slot }}
</button>
