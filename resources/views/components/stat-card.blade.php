@props(['label', 'value', 'icon' => 'book-open', 'hint' => null, 'tone' => 'default'])

@php
    $tones = [
        'default' => 'text-black',
        'accent' => 'text-black',
        'warn' => 'text-black',
        'danger' => 'text-accent',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'border-y border-black py-5']) }}>
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">{{ $label }}</p>
            <p class="mt-3 font-serif-display text-4xl font-bold leading-none tracking-tight sm:text-5xl">{{ $value }}</p>
            @if ($hint)
                <p class="mt-1 text-xs text-muted">{{ $hint }}</p>
            @endif
        </div>
        <span class="border-l border-black pl-3 {{ $tones[$tone] ?? $tones['default'] }}">
            <x-icon :name="$icon" class="size-5" />
        </span>
    </div>
</div>
