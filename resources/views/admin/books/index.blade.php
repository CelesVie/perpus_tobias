<x-layouts.admin title="Manajemen buku" heading="Buku">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Koleksi / Inventaris</p>
            <h1 class="mt-3 font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Manajemen buku</h1>
            <p class="mt-5 text-base text-muted">Tambah, ubah, dan hapus judul koleksi.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn-primary btn-sm"><x-icon name="plus" class="size-4" /> Tambah buku</a>
    </div>

    <form method="GET" class="mt-8 flex max-w-2xl gap-2 border-y border-black py-4">
        <input name="q" value="{{ $term }}" class="field" placeholder="Cari judul, penulis, ISBN" aria-label="Cari buku">
        <button class="btn-outline" type="submit"><x-icon name="search" class="size-4" /> Cari</button>
    </form>

    <div class="mt-8 overflow-x-auto border-y border-black">
        @if ($books->isEmpty())
            <div class="p-6"><x-empty-state title="Belum ada buku" description="Tambahkan judul pertama ke katalog." icon="book-open" /></div>
        @else
            <table class="table-base min-w-[760px]">
                <thead>
                    <tr><th>Judul</th><th>Kategori</th><th>Eksemplar</th><th>Ketersediaan</th><th class="text-right">Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                <p class="font-semibold">{{ $book->title }}</p>
                                <p class="text-xs text-muted">{{ $book->authorNames() }} &middot; {{ $book->publication_year ?: '—' }}</p>
                            </td>
                            <td class="text-xs">{{ $book->category?->name }}</td>
                            <td>{{ $book->total_copies }}</td>
                            <td>
                                <span class="badge {{ $book->isAvailable() ? 'bg-accent-soft text-accent' : 'bg-red-50 text-red-600' }}">
                                    {{ $book->available_copies }} tersedia
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex gap-1">
                                    <a href="{{ route('books.show', $book) }}" class="btn-ghost btn-sm" title="Lihat di situs"><x-icon name="eye" class="size-4" /></a>
                                    <a href="{{ route('admin.books.edit', $book) }}" class="btn-outline btn-sm"><x-icon name="pencil" class="size-4" /> Ubah</a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" x-data="{ confirm: false }"
                                          @submit="confirm || ($event.preventDefault(), confirm = true)">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger btn-sm" type="submit" x-show="!confirm"><x-icon name="trash-2" class="size-4" /></button>
                                        <button class="btn-danger btn-sm" type="submit" x-show="confirm" x-cloak>Hapus?</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-black px-4 py-3">{{ $books->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
