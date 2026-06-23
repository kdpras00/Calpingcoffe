@props(['title', 'value', 'color' => 'stone', 'isCurrency' => false])

@php
    $colors = [
        'emerald' => [
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-600',
            'hover_bg' => 'group-hover:bg-emerald-500',
            'hover_shadow' => 'group-hover:shadow-emerald-500/30',
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-600',
            'hover_bg' => 'group-hover:bg-amber-500',
            'hover_shadow' => 'group-hover:shadow-amber-500/30',
        ],
        'rose' => [
            'bg' => 'bg-rose-50',
            'text' => 'text-rose-600',
            'hover_bg' => 'group-hover:bg-rose-500',
            'hover_shadow' => 'group-hover:shadow-rose-500/30',
        ],
        'indigo' => [
            'bg' => 'bg-indigo-50',
            'text' => 'text-indigo-600',
            'hover_bg' => 'group-hover:bg-indigo-500',
            'hover_shadow' => 'group-hover:shadow-indigo-500/30',
        ],
        'stone' => [
            'bg' => 'bg-stone-50',
            'text' => 'text-stone-900',
            'hover_bg' => 'group-hover:bg-stone-900',
            'hover_shadow' => 'group-hover:shadow-stone-900/20',
        ],
    ];

    $theme = $colors[$color] ?? $colors['stone'];
@endphp

<div class="h-full bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 group transform hover:-translate-y-1 flex flex-col justify-between">
    <div class="w-12 h-12 rounded-2xl {{ $theme['bg'] }} flex items-center justify-center {{ $theme['text'] }} {{ $theme['hover_bg'] }} group-hover:text-white transition-all duration-500 group-hover:shadow-lg {{ $theme['hover_shadow'] }} mb-6">
        <div class="transform group-hover:scale-110 transition-transform duration-500">
            {{ $icon }}
        </div>
    </div>
    <div>
        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-2">{{ $title }}</p>
        <h3 class="{{ strlen($value) > 7 ? 'text-3xl' : 'text-4xl' }} font-bold text-stone-900 tracking-tight">
            @if($isCurrency)
                <span class="text-xs text-stone-400 font-normal mr-1">IDR</span>
            @endif
            {{ $value }}
        </h3>
    </div>
</div>
