@props(['name', 'title', 'description' => null])

<section {{ $attributes->merge(['class' => 'border-b border-black bg-white']) }}>
    <div class="mx-auto max-w-screen-2xl px-5 py-12 sm:px-8 sm:py-16 lg:px-12">
        <nav class="flex items-center gap-2 font-sans text-[10px] tracking-[0.15em] text-muted uppercase" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-ink">Beranda</a>
            <x-icon name="chevron-right" class="size-3" />
            <span class="font-medium text-ink">{{ $name }}</span>
        </nav>
        <h1 class="mt-6 max-w-5xl font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-7xl lg:text-8xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-6 mb-2 max-w-2xl text-base leading-relaxed text-muted sm:text-lg">{{ $description }}</p>
        @endif
    </div>
</section>
