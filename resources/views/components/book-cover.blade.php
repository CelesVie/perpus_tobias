@props(['book'])

@php
    [$a, $b, $c] = $book->coverPalette();
    $initials = \Illuminate\Support\Str::of($book->title)->explode(' ')->take(2)
        ->map(fn ($w) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($w, 0, 1)))->implode('');
@endphp

<div {{ $attributes->merge(['class' => 'relative overflow-hidden']) }}>
    @if ($book->coverUrl())
        <img src="{{ $book->coverUrl() }}" alt="Sampul {{ $book->title }}" class="size-full object-cover" loading="lazy">
    @else
        <div class="flex size-full flex-col justify-between p-4" style="background: linear-gradient(150deg, {{ $a }} 0%, {{ $b }} 100%);">
            <span class="text-[10px] font-bold tracking-[0.2em] uppercase" style="color: {{ $c }}aa">Koleksi</span>
            <div>
                <p class="font-display text-2xl leading-none" style="color: {{ $c }}">{{ $initials }}</p>
                <p class="mt-2 line-clamp-3 text-xs font-semibold leading-snug" style="color: {{ $c }}e6">{{ $book->title }}</p>
            </div>
        </div>
    @endif
</div>
