<x-layouts.member title="Dasbor anggota">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="eyebrow">Selamat datang</p>
            <h1 class="mt-1.5 font-display text-2xl font-semibold sm:text-3xl">{{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-muted">
                Anggota sejak {{ auth()->user()->joined_at?->translatedFormat('F Y') ?? now()->translatedFormat('F Y') }}.
                Batas pinjam {{ $loanLimit }} buku, durasi {{ $loanDays }} hari.
            </p>
        </div>
        <a href="{{ route('member.books') }}" class="btn-primary btn-sm">
            <x-icon name="search" class="size-4" /> Cari buku
        </a>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <x-stat-card label="Pinjaman aktif" :value="$active->count()" icon="book-marked" tone="accent"
            :hint="'dari batas '.$loanLimit.' buku'" />
        <x-stat-card label="Menunggu persetujuan" :value="$pending->count()" icon="clock" tone="warn" />
        <x-stat-card label="Denda belum dibayar" :value="'Rp'.number_format($unpaidFine, 0, ',', '.')" icon="receipt"
            :tone="$unpaidFine > 0 ? 'danger' : 'default'" :hint="'Rp'.number_format($finePerDay, 0, ',', '.').' / hari'" />
    </div>

    <section class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-lg font-semibold">Sedang dipinjam</h2>
            <a href="{{ route('member.borrowings.index') }}" class="link text-sm">Semua peminjaman</a>
        </div>

        @if ($active->isEmpty())
            <div class="mt-4">
                <x-empty-state title="Tidak ada pinjaman aktif" description="Cari buku di katalog lalu ajukan peminjaman." icon="book-open">
                    <x-slot:action><a href="{{ route('member.books') }}" class="btn-primary btn-sm">Jelajahi katalog</a></x-slot:action>
                </x-empty-state>
            </div>
        @else
            <ul class="mt-4 space-y-3">
                @foreach ($active as $borrowing)
                    @php $late = $borrowing->isOverdue(); @endphp
                    <li class="card flex flex-wrap items-center gap-4 p-4">
                        <x-book-cover :book="$borrowing->book" class="h-20 w-14 rounded-md" />
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('member.borrowings.show', $borrowing) }}" class="line-clamp-1 font-semibold hover:text-accent">
                                {{ $borrowing->book->title }}
                            </a>
                            <p class="mt-0.5 truncate text-xs text-muted">{{ $borrowing->book->authorNames() }}</p>
                            <p class="mt-1.5 text-xs {{ $late ? 'font-semibold text-red-600' : 'text-muted' }}">
                                <x-icon name="calendar" class="mr-1 inline size-3.5" />
                                Jatuh tempo {{ $borrowing->due_at?->translatedFormat('d M Y') }}
                                @if ($late) &middot; terlambat {{ $borrowing->daysLate() }} hari @endif
                            </p>
                        </div>
                        <a href="{{ route('member.borrowings.show', $borrowing) }}" class="btn-outline btn-sm">Detail</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    @if ($pending->isNotEmpty())
        <section class="mt-8">
            <h2 class="font-display text-lg font-semibold">Menunggu persetujuan</h2>
            <ul class="mt-4 space-y-3">
                @foreach ($pending as $borrowing)
                    <li class="card flex flex-wrap items-center gap-3 p-4">
                        <div class="min-w-0 flex-1">
                            <p class="line-clamp-1 text-sm font-semibold">{{ $borrowing->book->title }}</p>
                            <p class="text-xs text-muted">Diajukan {{ $borrowing->requested_at->diffForHumans() }}</p>
                        </div>
                        <x-status-badge :status="$borrowing->status" />
                        <a href="{{ route('member.borrowings.show', $borrowing) }}" class="btn-ghost btn-sm">Lihat</a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <section class="mt-8">
        <h2 class="font-display text-lg font-semibold">Rekomendasi untuk Anda</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            @forelse ($recommended as $book)
                <x-book-card :book="$book" compact />
            @empty
                <x-empty-state title="Belum ada rekomendasi" icon="sparkles" />
            @endforelse
        </div>
    </section>
</x-layouts.member>
