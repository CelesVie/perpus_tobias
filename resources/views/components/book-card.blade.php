@props(['book', 'href' => null, 'compact' => false])

@php
    $url = $href ?? (request()->routeIs('member.*') ? route('member.books.show', $book) : route('books.show', $book));
    $available = $book->isAvailable();
@endphp

<article {{ $attributes->merge(['class' => 'group border-t border-black pt-4']) }}>
    <a href="{{ $url }}" class="block overflow-hidden border border-line">
        <x-book-cover :book="$book" :class="$compact ? 'h-44' : 'h-56'" />
    </a>
    <div class="space-y-2 pt-4">
        <div class="flex items-center justify-between gap-2">
            <span class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">{{ $book->category?->name }}</span>
            <span class="font-sans text-[10px] font-semibold tracking-widest uppercase {{ $available ? 'text-black' : 'text-accent' }}">
                {{ $available ? $book->available_copies.' tersedia' : 'Habis' }}
            </span>
        </div>
        <h3 class="font-serif-display text-2xl font-bold leading-tight tracking-tight sm:text-3xl">
            <a href="{{ $url }}" class="hover:underline hover:underline-offset-4">{{ $book->title }}</a>
        </h3>
        <p class="truncate text-sm text-muted">{{ $book->authorNames() ?: 'Tanpa penulis' }}</p>
        <p class="font-sans text-[10px] tracking-[0.1em] text-muted uppercase">{{ $book->publisher?->name ?? 'Tanpa penerbit' }} · {{ $book->publication_year ?: '—' }}</p>
    </div>
</article>
