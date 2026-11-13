@props(['book'])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-none border border-black bg-paper']) }}>
    @if ($book->coverUrl())
        <img src="{{ $book->coverUrl() }}" alt="Sampul {{ $book->title }}" class="flex size-full object-cover" loading="lazy">
    @else
        @php $initial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($book->title, 0, 1)); @endphp
        <svg class="absolute inset-0 size-full text-line" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
            <path d="M-10,-10 L110,110" stroke="currentColor" stroke-width="1" />
            <path d="M110,-10 L-10,110" stroke="currentColor" stroke-width="1" />
        </svg>
        <div class="relative flex size-full items-center justify-center">
            <span class="font-serif-display text-3xl font-bold tracking-tight text-muted">{{ $initial }}</span>
        </div>
    @endif
</div>
