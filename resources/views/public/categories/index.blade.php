<x-layouts.public title="Kategori koleksi" description="Jelajahi koleksi perpustakaan berdasarkan kategori.">
    <x-page-header name="Kategori" title="Kategori koleksi"
        description="Rak kami dikelompokkan agar mudah ditelusuri. Pilih kategori untuk melihat judul di dalamnya." />

    <div class="mx-auto max-w-screen-2xl px-5 py-12 sm:px-8 lg:px-12">
        @if ($categories->isEmpty())
            <x-empty-state title="Belum ada kategori" icon="tags" />
        @else
            <div class="grid gap-x-8 gap-y-0 divide-y divide-black border-y border-black sm:grid-cols-2 sm:divide-y-0">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="group border-b border-black py-6 transition-colors hover:bg-primary-ghost/40 sm:border-b-0 sm:border-r sm:pr-6">
                        <div class="flex items-start justify-between gap-3">
                            <span class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Kategori</span>
                            <span class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">{{ $category->books_count }} judul</span>
                        </div>
                        <h2 class="mt-5 font-serif-display text-3xl font-bold leading-none tracking-tight">{{ $category->name }}</h2>
                        <p class="mt-1 line-clamp-2 text-sm text-muted">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
