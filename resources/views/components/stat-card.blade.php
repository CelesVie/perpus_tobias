@props(['label', 'value', 'icon' => 'book-open', 'hint' => null, 'tone' => 'default'])

@php
    $tones = [
        'default' => 'bg-primary-ghost text-primary',
        'accent' => 'bg-accent-soft text-accent',
        'warn' => 'bg-amber-50 text-amber-700',
        'danger' => 'bg-red-50 text-red-600',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'panel']) }}>
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-xs font-semibold tracking-wide text-muted uppercase">{{ $label }}</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $value }}</p>
            @if ($hint)
                <p class="mt-1 text-xs text-muted">{{ $hint }}</p>
            @endif
        </div>
        <span class="grid size-10 place-items-center rounded-lg {{ $tones[$tone] ?? $tones['default'] }}">
            <x-icon :name="$icon" class="size-5" />
        </span>
    </div>
</div>
