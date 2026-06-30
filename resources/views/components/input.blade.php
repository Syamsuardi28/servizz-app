@props(['disabled' => false, 'icon' => null])

<div class="relative w-full">
    @if($icon)
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <i data-lucide="{{ $icon }}" class="h-5 w-5 text-gray-400"></i>
        </div>
    @endif
    
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full rounded-xl border border-gray-200 dark:border-[#3E3E3A] bg-white dark:bg-[#1f1f1e] text-gray-900 dark:text-[#EDEDEC] placeholder-gray-400 dark:placeholder-gray-500 shadow-sm transition-all duration-200 focus:border-primary-500 focus:ring focus:ring-primary-500/20 disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 dark:disabled:bg-[#161615] dark:disabled:border-[#20201f] dark:disabled:text-gray-500 py-3 ' . ($icon ? 'pl-11 pr-4 ' : 'px-4 ')]) !!}>
</div>
