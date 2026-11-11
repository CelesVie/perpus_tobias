<x-layouts.public title="Pustaka Nusantara — Perpustakaan terbuka untuk semua"
    description="Telusuri katalog, cek ketersediaan, dan ajukan peminjaman buku di Perpustakaan Pustaka Nusantara.">

    <section class="relative overflow-hidden border-b border-line bg-surface">
        <div class="absolute inset-0 opacity-[0.5]" style="background-image: radial-gradient(#24344714 1px, transparent 1px); background-size: 26px 26px;"></div>
        <div class="relative mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:py-24">
            <div>
                <p class="eyebrow">Perpustakaan Pustaka Nusantara</p>
                <h1 class="mt-4 font-display text-4xl leading-[1.1] font-semibold tracking-tight sm:text-5xl lg:text-6xl">
                    Temukan bacaan berikutnya,<br><span class="text-accent">pinjam dengan tenang.</span>
                </h1>
                <p class="mt-5 mb-4 max-w-xl text-base leading-relaxed text-muted">
                    Katalog terbuka untuk semua. Anggota dapat mengajukan peminjaman daring dan memantau jatuh tempo tanpa antre di meja layanan.
                </p>

                <form action="{{ route('books.index') }}" method="GET" class="mt-8 flex max-w-xl gap-2" role="search">
                    <div class="relative flex-1">
                        <x-icon name="search" class="absolute top-1/2 left-3.5 size-4 -translate-y-1/2 text-muted" />
                        <input type="search" name="q" placeholder="Cari judul, penulis, atau ISBN…"
                               aria-label="Cari buku"
                               class="field pl-10">
                    </div>
                    <button class="btn-primary" type="submit">Cari</button>
                </form>

                <dl class="mt-10 grid max-w-xl grid-cols-2 gap-x-6 gap-y-4 sm:grid-cols-4">
                    @foreach ([['Judul', $stats['titles'], 'book-open'], ['Eksemplar', $stats['copies'], 'library'], ['Anggota', $stats['members'], 'users'], ['Kategori', $stats['categories'], 'tags']] as [$label, $value, $icon])
                        <div class="border-l-2 border-accent/40 pl-3">
                            <dt class="flex items-center gap-1.5 text-[11px] font-semibold tracking-wide text-muted uppercase">
                                <x-icon :name="$icon" class="size-3.5" />{{ $label }}
                            </dt>
                            <dd class="font-display text-2xl font-semibold">{{ number_format($value, 0, ',', '.') }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="relative hidden lg:block">
                <div class="absolute inset-x-6 top-4 bottom-0 rounded-2xl bg-primary-ghost"></div>
                <div class="relative grid grid-cols-2 gap-4">
                    @foreach ($latest->take(2) as $index => $book)
                        <article class="card overflow-hidden shadow-sm {{ $index === 1 ? 'mt-10' : '' }}">
                            <x-book-cover :book="$book" class="h-52" />
                            <div class="p-3">
                                <p class="line-clamp-2 text-sm font-semibold">{{ $book->title }}</p>
                                <p class="mt-1 truncate text-xs text-muted">{{ $book->authorNames() ?: 'Tanpa penulis' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="relative mt-4 flex items-center gap-3 rounded-xl border border-line bg-surface p-3">
                    <span class="grid size-9 place-items-center rounded-lg bg-accent-soft text-accent"><x-icon name="clock" class="size-4" /></span>
                    <div class="text-xs">
                        <p class="font-semibold">Layanan {{ \App\Models\Setting::get('loan_duration_days') }} hari</p>
                        <p class="text-muted">Perpanjangan di meja sirkulasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Jelajahi rak</p>
                <h2 class="mt-2 font-display text-2xl font-semibold tracking-tight sm:text-3xl">Kategori populer</h2>
            </div>
            <a href="{{ route('categories.index') }}" class="link text-sm">Semua kategori</a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @forelse ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="group flex items-center justify-between gap-3 rounded-xl border border-line bg-surface px-4 py-4 transition hover:border-accent/50 hover:bg-accent-soft/40">
                    <span class="text-sm font-semibold">{{ $category->name }}</span>
                    <span class="badge bg-paper text-muted group-hover:bg-surface">{{ $category->books_count }}</span>
                </a>
            @empty
                <p class="text-sm text-muted">Kategori belum tersedia.</p>
            @endforelse
        </div>
    </section>

    <section class="border-y border-line bg-surface">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Baru di rak</p>
                    <h2 class="mt-2 font-display text-2xl font-semibold tracking-tight sm:text-3xl">Koleksi terbaru</h2>
                </div>
                <a href="{{ route('books.index') }}" class="link text-sm">Lihat katalog</a>
            </div>
            <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latest as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div>
            <p class="eyebrow">Paling dipinjam</p>
            <h2 class="mt-2 font-display text-2xl font-semibold tracking-tight sm:text-3xl">Digemari pembaca</h2>
        </div>
        <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($popular as $book)
                <x-book-card :book="$book" />
            @empty
                <x-empty-state title="Belum ada data peminjaman" description="Koleksi populer muncul setelah ada transaksi peminjaman." />
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 pb-4 sm:px-6">
        <div class="grid gap-6 rounded-2xl bg-primary p-8 text-white sm:p-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div>
                <p class="eyebrow !text-accent-soft">Keanggotaan</p>
                <h2 class="mt-3 font-display text-2xl font-semibold tracking-tight sm:text-3xl">Belum jadi anggota?</h2>
                <p class="mt-3 max-w-xl text-sm text-white/75">
                    Pendaftaran gratis. Anggota dapat meminjam hingga {{ \App\Models\Setting::get('max_active_loans') }} buku sekaligus
                    dengan durasi {{ \App\Models\Setting::get('loan_duration_days') }} hari per buku.
                </p>
            </div>
            <div class="flex flex-wrap gap-3 lg:justify-end">
                <a href="{{ route('register') }}" class="btn-accent">Daftar sekarang</a>
                <a href="{{ route('about') }}" class="btn-outline !border-white/25 !bg-transparent !text-white hover:!bg-white/10">Tentang kami</a>
            </div>
        </div>
    </section>
</x-layouts.public>
