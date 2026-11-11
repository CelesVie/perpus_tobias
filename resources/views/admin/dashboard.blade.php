<x-layouts.admin title="Dasbor" heading="Dasbor pustakawan">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="eyebrow">Ringkasan hari ini</p>
            <h1 class="mt-1.5 font-display text-2xl font-semibold">{{ now()->translatedFormat('l, d F Y') }}</h1>
            <p class="mt-1 text-sm text-muted">Pantau antrean permohonan dan keterlambatan pengembalian.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.borrowings.index') }}" class="btn-primary btn-sm">
                <x-icon name="clipboard-list" class="size-4" /> Antrean ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('admin.books.create') }}" class="btn-outline btn-sm"><x-icon name="plus" class="size-4" /> Buku baru</a>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Judul buku" :value="number_format($stats['titles'])" icon="book-open" hint="{{ number_format($stats['copies']) }} eksemplar" />
        <x-stat-card label="Anggota terdaftar" :value="number_format($stats['members'])" icon="users" tone="accent" />
        <x-stat-card label="Peminjaman aktif" :value="number_format($stats['active'])" icon="book-marked" tone="accent" :hint="$stats['pending'].' menunggu persetujuan'" />
        <x-stat-card label="Terlambat" :value="number_format($stats['overdue'])" icon="triangle-alert" :tone="$stats['overdue'] > 0 ? 'danger' : 'default'" hint="Denda belum lunas: Rp{{ number_format($stats['fines'], 0, ',', '.') }}" />
    </div>

    <div class="mt-6 grid gap-5 lg:grid-cols-[1.4fr_0.6fr]">
        <div class="panel">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-semibold">Permohonan terbaru</h2>
                    <p class="text-xs text-muted">Perlu keputusan pustakawan</p>
                </div>
                <a href="{{ route('admin.borrowings.index') }}" class="link text-sm">Lihat semua</a>
            </div>

            <div class="mt-4 space-y-2">
                @forelse ($queue as $item)
                    <div class="flex flex-wrap items-center gap-3 rounded-lg border border-line px-3 py-2.5">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold">{{ $item->book?->title }}</p>
                            <p class="text-xs text-muted">{{ $item->user?->name }} &middot; {{ $item->requested_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.borrowings.show', $item) }}" class="btn-outline btn-sm">Proses</a>
                    </div>
                @empty
                    <x-empty-state title="Antrean kosong" description="Semua permohonan sudah diproses." icon="check" class="!py-8" />
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2 class="font-display text-lg font-semibold">Buku terlambat</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @forelse ($overdueList as $item)
                    <li class="border-l-2 border-red-300 pl-3">
                        <a href="{{ route('admin.borrowings.show', $item) }}" class="line-clamp-1 font-semibold hover:text-accent">{{ $item->book?->title }}</a>
                        <p class="text-xs text-red-600">{{ $item->user?->name }} &middot; {{ $item->daysLate() }} hari</p>
                    </li>
                @empty
                    <li class="text-sm text-muted">Tidak ada keterlambatan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-6 grid gap-5 lg:grid-cols-[1.4fr_0.6fr]">
        <div class="panel">
            <h2 class="font-display text-lg font-semibold">Peminjaman 6 bulan terakhir</h2>
            <div class="mt-6 flex h-40 items-end gap-3">
                @php $max = max(1, $monthly->max('total')); @endphp
                @foreach ($monthly as $month)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="flex w-full flex-1 items-end">
                            <div class="w-full rounded-t-md bg-accent/70 transition hover:bg-accent"
                                 style="height: {{ max(4, round($month['total'] / $max * 100)) }}%"
                                 title="{{ $month['total'] }} peminjaman"></div>
                        </div>
                        <span class="text-[11px] text-muted">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <h2 class="font-display text-lg font-semibold">Koleksi per kategori</h2>
            <ul class="mt-4 space-y-3">
                @foreach ($byCategory as $category)
                    <li>
                        <div class="flex justify-between text-xs"><span class="font-medium">{{ $category->name }}</span><span class="text-muted">{{ $category->books_count }}</span></div>
                        <div class="mt-1 h-1.5 rounded-full bg-primary-ghost">
                            <div class="h-full rounded-full bg-primary" style="width: {{ min(100, $category->books_count * 8) }}%"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-6 panel">
        <h2 class="font-display text-lg font-semibold">Aktivitas terbaru</h2>
        <ul class="mt-4 divide-y divide-line text-sm">
            @forelse ($activity as $log)
                <li class="flex flex-wrap items-center gap-2 py-2.5">
                    <span class="badge bg-paper text-muted">{{ $log->action }}</span>
                    <span class="min-w-0 flex-1">{{ $log->description }}</span>
                    <span class="text-xs text-muted">{{ $log->user?->name ?? 'Sistem' }} &middot; {{ $log->created_at?->diffForHumans() }}</span>
                </li>
            @empty
                <li class="py-3 text-muted">Belum ada aktivitas tercatat.</li>
            @endforelse
        </ul>
    </div>
</x-layouts.admin>
