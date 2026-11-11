@php $layout = request()->routeIs('member.*') ? 'layouts.member' : 'layouts.public'; @endphp

<x-dynamic-component :component="$layout" title="Katalog buku">
    <x-page-header name="Katalog" title="Katalog buku"
        description="Telusuri koleksi berdasarkan kata kunci, kategori, penulis, penerbit, atau tahun terbit." />

    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[260px_1fr]">
        <aside>
            <form method="GET" action="{{ url()->current() }}" class="panel space-y-5" x-data="{ open: false }">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold">Filter koleksi</p>
                    <button type="button" class="btn-ghost btn-sm lg:hidden" @click="open = !open" aria-controls="filter-body">
                        <x-icon name="filter" class="size-4" /> Filter
                    </button>
                </div>

                <div class="space-y-5" id="filter-body" x-show="open || window.innerWidth >= 1024" x-cloak>
                    <div>
                        <label class="label" for="q">Kata kunci</label>
                        <input id="q" name="q" value="{{ $filters['q'] ?? '' }}" class="field" placeholder="Judul, penulis, ISBN">
                    </div>

                    <div>
                        <label class="label" for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="field">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected(($filters['kategori'] ?? '') === $category->slug)>
                                    {{ $category->name }} ({{ $category->books_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label" for="penulis">Penulis</label>
                        <select id="penulis" name="penulis" class="field">
                            <option value="">Semua penulis</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected((int) ($filters['penulis'] ?? 0) === $author->id)>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label" for="penerbit">Penerbit</label>
                        <select id="penerbit" name="penerbit" class="field">
                            <option value="">Semua penerbit</option>
                            @foreach ($publishers as $publisher)
                                <option value="{{ $publisher->id }}" @selected((int) ($filters['penerbit'] ?? 0) === $publisher->id)>{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="label" for="tahun">Tahun</label>
                            <select id="tahun" name="tahun" class="field">
                                <option value="">Semua</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" @selected((int) ($filters['tahun'] ?? 0) === $year)>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label" for="ketersediaan">Status</label>
                            <select id="ketersediaan" name="ketersediaan" class="field">
                                <option value="">Semua</option>
                                <option value="tersedia" @selected(($filters['ketersediaan'] ?? '') === 'tersedia')>Tersedia</option>
                                <option value="dipinjam" @selected(($filters['ketersediaan'] ?? '') === 'dipinjam')>Habis dipinjam</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button class="btn-primary btn-sm flex-1" type="submit">Terapkan</button>
                        <a href="{{ url()->current() }}" class="btn-outline btn-sm">Reset</a>
                    </div>
                </div>
            </form>
        </aside>

        <section>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-muted">
                    <span class="font-semibold text-ink">{{ $books->total() }}</span> buku ditemukan
                </p>
                <form method="GET" action="{{ url()->current() }}">
                    @foreach (collect($filters)->except('urut') as $key => $value)
                        @if (filled($value))<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
                    @endforeach
                    <label class="sr-only" for="urut">Urutkan</label>
                    <select id="urut" name="urut" class="field !py-2 text-xs" onchange="this.form.submit()">
                        <option value="">Terbaru</option>
                        <option value="populer" @selected(($filters['urut'] ?? '') === 'populer')>Paling dipinjam</option>
                        <option value="judul" @selected(($filters['urut'] ?? '') === 'judul')>Judul A–Z</option>
                    </select>
                </form>
            </div>

            @if ($books->isEmpty())
                <div class="mt-6">
                    <x-empty-state title="Tidak ada buku yang cocok"
                        description="Coba kata kunci lain atau longgarkan filter yang dipakai." icon="search">
                        <x-slot:action>
                            <a href="{{ url()->current() }}" class="btn-outline btn-sm">Hapus semua filter</a>
                        </x-slot:action>
                    </x-empty-state>
                </div>
            @else
                <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($books as $book)
                        <x-book-card :book="$book" />
                    @endforeach
                </div>
                <div class="mt-8">{{ $books->links() }}</div>
            @endif
        </section>
    </div>
</x-dynamic-component>
