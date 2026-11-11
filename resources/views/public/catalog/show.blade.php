@php $layout = request()->routeIs('member.*') ? 'layouts.member' : 'layouts.public'; @endphp

<x-dynamic-component :component="$layout" :title="$book->title">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <nav class="flex flex-wrap items-center gap-1.5 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-ink">Beranda</a>
            <x-icon name="chevron-right" class="size-3" />
            <a href="{{ route('books.index') }}" class="hover:text-ink">Katalog</a>
            <x-icon name="chevron-right" class="size-3" />
            <a href="{{ route('categories.show', $book->category) }}" class="hover:text-ink">{{ $book->category->name }}</a>
            <x-icon name="chevron-right" class="size-3" />
            <span class="line-clamp-1 font-medium text-ink">{{ $book->title }}</span>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-[300px_1fr]">
            <div>
                <x-book-cover :book="$book" class="aspect-2/3 rounded-xl border border-line shadow-sm" />
                <dl class="mt-5 space-y-2.5 rounded-xl border border-line bg-surface p-4 text-sm">
                    <div class="flex justify-between gap-3"><dt class="text-muted">Ketersediaan</dt>
                        <dd class="font-semibold {{ $book->isAvailable() ? 'text-accent' : 'text-red-600' }}">
                            {{ $book->available_copies }} dari {{ $book->total_copies }} eksemplar
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3"><dt class="text-muted">Halaman</dt><dd>{{ $book->page_count ?: '—' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted">ISBN</dt><dd class="font-mono text-xs">{{ $book->isbn ?: '—' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted">Dilihat</dt><dd>{{ number_format($book->view_count, 0, ',', '.') }} kali</dd></div>
                </dl>
            </div>

            <div>
                <p class="eyebrow">{{ $book->category->name }}</p>
                <h1 class="mt-2 font-display text-3xl leading-tight font-semibold tracking-tight sm:text-4xl">{{ $book->title }}</h1>
                <p class="mt-3 text-sm text-muted">
                    oleh <span class="font-semibold text-ink">{{ $book->authorNames() ?: 'Tanpa penulis' }}</span>
                    &middot; {{ $book->publisher?->name ?? 'Tanpa penerbit' }}
                    &middot; {{ $book->publication_year ?: 'Tahun tidak dicatat' }}
                </p>

                <div class="mt-6 border-t border-line pt-6">
                    <h2 class="text-sm font-bold tracking-wide uppercase">Deskripsi</h2>
                    <p class="mt-3 leading-relaxed text-ink/90">{{ $book->description ?: 'Deskripsi belum tersedia untuk buku ini.' }}</p>
                </div>

                <div class="mt-8 rounded-xl border border-line bg-surface p-5">
                    @guest
                        <p class="text-sm text-muted">Masuk sebagai anggota untuk mengajukan peminjaman buku ini.</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-outline">Daftar anggota</a>
                        </div>
                    @else
                        @if ($activeBorrowing)
                            <p class="text-sm font-semibold">
                                Anda sudah punya permohonan aktif untuk buku ini.
                            </p>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <x-status-badge :status="$activeBorrowing->status" />
                                <a href="{{ route('member.borrowings.show', $activeBorrowing) }}" class="link text-sm">Lihat status</a>
                            </div>
                        @elseif ($book->isAvailable())
                            <form method="POST" action="{{ route('member.borrowings.store', $book) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="label" for="member_note">Catatan untuk pustakawan (opsional)</label>
                                    <textarea id="member_note" name="member_note" rows="2" class="field"
                                              placeholder="Contoh: untuk tugas akhir">{{ old('member_note') }}</textarea>
                                    @error('book') <p class="error">{{ $message }}</p> @enderror
                                    @error('stock') <p class="error">{{ $message }}</p> @enderror
                                </div>
                                <button class="btn-primary" type="submit">
                                    <x-icon name="book-open-check" class="size-4" /> Ajukan peminjaman
                                </button>
                                <p class="text-xs text-muted">
                                    Durasi {{ \App\Models\Setting::get('loan_duration_days') }} hari. Permohonan menunggu persetujuan pustakawan.
                                </p>
                            </form>
                        @else
                            <p class="text-sm font-semibold text-red-700">Semua eksemplar sedang dipinjam.</p>
                            <p class="mt-1 text-sm text-muted">Coba periksa kembali dalam beberapa hari.</p>
                        @endif
                    @endguest
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <section class="mt-14">
                <h2 class="font-display text-xl font-semibold">Buku lain di kategori {{ $book->category->name }}</h2>
                <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $item)
                        <x-book-card :book="$item" compact />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-dynamic-component>
