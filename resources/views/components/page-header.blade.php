@props(['name', 'title', 'description' => null])

<section {{ $attributes->merge(['class' => 'border-b border-line bg-surface']) }}>
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <nav class="flex items-center gap-1.5 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-ink">Beranda</a>
            <x-icon name="chevron-right" class="size-3" />
            <span class="font-medium text-ink">{{ $name }}</span>
        </nav>
        <h1 class="mt-3 font-display text-2xl font-semibold tracking-tight sm:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 mb-4 max-w-2xl text-sm leading-relaxed text-muted">{{ $description }}</p>
        @endif
    </div>
</section>
