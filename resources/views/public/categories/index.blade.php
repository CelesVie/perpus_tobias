<x-layouts.public title="Kategori koleksi" description="Jelajahi koleksi perpustakaan berdasarkan kategori.">
    <x-page-header name="Kategori" title="Kategori koleksi"
        description="Rak kami dikelompokkan agar mudah ditelusuri. Pilih kategori untuk melihat judul di dalamnya." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        @if ($categories->isEmpty())
            <x-empty-state title="Belum ada kategori" icon="tags" />
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="card group p-5 transition hover:border-accent/50 hover:bg-accent-soft/30">
                        <div class="flex items-start justify-between gap-3">
                            <span class="grid size-10 place-items-center rounded-lg bg-primary-ghost text-primary transition group-hover:bg-accent group-hover:text-white">
                                <x-icon name="tags" class="size-5" />
                            </span>
                            <span class="badge bg-paper text-muted">{{ $category->books_count }} judul</span>
                        </div>
                        <h2 class="mt-4 font-display text-lg font-semibold">{{ $category->name }}</h2>
                        <p class="mt-1 line-clamp-2 text-sm text-muted">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
