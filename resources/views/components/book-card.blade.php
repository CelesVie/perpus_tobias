@props(['book', 'href' => null, 'compact' => false])

@php
    $url = $href ?? (request()->routeIs('member.*') ? route('member.books.show', $book) : route('books.show', $book));
    $available = $book->isAvailable();
@endphp

<article {{ $attributes->merge(['class' => 'group card overflow-hidden transition hover:-translate-y-0.5 hover:shadow-sm']) }}>
    <a href="{{ $url }}" class="block">
        <x-book-cover :book="$book" :class="$compact ? 'h-44' : 'h-56'" />
    </a>
    <div class="space-y-2 p-4">
        <div class="flex items-center justify-between gap-2">
            <span class="text-[11px] font-semibold tracking-wide text-accent uppercase">{{ $book->category?->name }}</span>
            <span class="badge {{ $available ? 'bg-accent-soft text-accent' : 'bg-primary-ghost text-muted' }}">
                {{ $available ? $book->available_copies.' tersedia' : 'Habis' }}
            </span>
        </div>
        <h3 class="line-clamp-2 font-semibold leading-snug">
            <a href="{{ $url }}" class="hover:text-accent">{{ $book->title }}</a>
        </h3>
        <p class="truncate text-xs text-muted">{{ $book->authorNames() ?: 'Tanpa penulis' }}</p>
        <p class="text-xs text-muted">{{ $book->publisher?->name ?? 'Tanpa penerbit' }} &middot; {{ $book->publication_year ?: '—' }}</p>
    </div>
</article>
