@props(['variant' => 'primary'])

@php
    $baseClasses = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold';
    
    $variants = [
        'primary' => 'bg-primary-100 dark:bg-primary-500/20 text-primary-700 dark:text-primary-400',
        'success' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400',
        'warning' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
        'danger' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400',
        'info' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
        'gray' => 'bg-gray-100 dark:bg-gray-500/20 text-gray-700 dark:text-gray-400',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
