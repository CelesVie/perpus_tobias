<x-layouts.public title="Pustaka Nusantara — Perpustakaan terbuka untuk semua"
    description="Telusuri katalog, cek ketersediaan, dan ajukan peminjaman buku di Perpustakaan Pustaka Nusantara.">

    <section class="border-b border-black bg-white">
        <div class="mx-auto max-w-screen-2xl px-5 py-16 sm:px-8 sm:py-24 lg:px-12 lg:py-32">
            <div class="max-w-6xl">
                <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Perpustakaan Pustaka Nusantara</p>
                <h1 class="mt-7 max-w-6xl font-serif-display text-6xl font-bold leading-[0.9] tracking-tight sm:text-8xl lg:text-9xl">
                    Temukan bacaan berikutnya, pinjam dengan tenang.
                </h1>
                <p class="mt-8 max-w-2xl font-serif-display text-xl leading-relaxed text-muted sm:text-2xl">
                    Katalog terbuka untuk semua. Anggota dapat mengajukan peminjaman daring dan memantau jatuh tempo tanpa antre di meja layanan.
                </p>

                <form action="{{ route('books.index') }}" method="GET" class="mt-10 flex max-w-2xl gap-2" role="search">
                    <div class="relative flex-1">
                        <x-icon name="search" class="absolute top-1/2 left-3.5 size-4 -translate-y-1/2 text-muted" />
                        <input type="search" name="q" placeholder="Cari judul, penulis, atau ISBN…"
                               aria-label="Cari buku"
                               class="field pl-10">
                    </div>
                    <button class="btn-primary" type="submit">Cari</button>
                </form>

                <dl class="mt-14 grid max-w-3xl grid-cols-2 gap-x-6 gap-y-5 border-t border-black pt-6 sm:grid-cols-4">
                    @foreach ([['Judul', $stats['titles'], 'book-open'], ['Eksemplar', $stats['copies'], 'library'], ['Anggota', $stats['members'], 'users'], ['Kategori', $stats['categories'], 'tags']] as [$label, $value, $icon])
                        <div class="border-l border-black pl-3">
                            <dt class="flex items-center gap-1.5 font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">
                                <x-icon :name="$icon" class="size-3.5" />{{ $label }}
                            </dt>
                            <dd class="mt-1 font-serif-display text-4xl font-bold leading-none tracking-tight">{{ number_format($value, 0, ',', '.') }}</dd>
                        </div>
                    @endforeach
                </dl>
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
