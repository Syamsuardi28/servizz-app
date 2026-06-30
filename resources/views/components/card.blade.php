<div {{ $attributes->merge(['class' => 'bg-surface dark:bg-[#161615] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3E3E3A] overflow-hidden relative group transition-all duration-300 hover:shadow-md hover:-translate-y-1 flex flex-col']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#3E3E3A] bg-gray-50/50 dark:bg-[#1f1f1e] flex items-center justify-between shrink-0">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6 flex-1 min-h-0 w-full flex flex-col">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-[#1f1f1e] border-t border-gray-100 dark:border-[#3E3E3A] shrink-0">
            {{ $footer }}
        </div>
    @endif
</div>
