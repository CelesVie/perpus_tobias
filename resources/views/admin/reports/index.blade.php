<x-layouts.admin title="Laporan" heading="Laporan">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-semibold">Laporan</h1>
            <p class="mt-1 text-sm text-muted">
                Periode {{ $from->translatedFormat('d M Y') }} – {{ $to->translatedFormat('d M Y') }}
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <form method="GET" class="flex gap-2">
                <select name="periode" class="field !py-2 text-xs" onchange="this.form.submit()" aria-label="Pilih periode">
                    <option value="minggu-ini" @selected($period === 'minggu-ini')>Minggu ini</option>
                    <option value="bulan-ini" @selected($period === 'bulan-ini')>Bulan ini</option>
                    <option value="bulan-lalu" @selected($period === 'bulan-lalu')>Bulan lalu</option>
                    <option value="tahun-ini" @selected($period === 'tahun-ini')>Tahun ini</option>
                </select>
            </form>
            <a href="{{ route('admin.reports.export', ['periode' => $period]) }}" class="btn-outline btn-sm">
                <x-icon name="download" class="size-4" /> Unduh CSV
            </a>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Permohonan" :value="number_format($summary['requests'])" icon="clipboard-list" />
        <x-stat-card label="Pengembalian" :value="number_format($summary['returns'])" icon="undo-2" tone="accent" />
        <x-stat-card label="Total denda" :value="'Rp'.number_format($summary['fines'], 0, ',', '.')" icon="receipt" tone="warn" />
        <x-stat-card label="Anggota baru" :value="number_format($summary['newMembers'])" icon="users" />
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-2">
        <div class="panel">
            <h2 class="font-display text-lg font-semibold">Buku paling dipinjam</h2>
            @if ($topBooks->isEmpty())
                <p class="mt-3 text-sm text-muted">Belum ada data pada periode ini.</p>
            @else
                <table class="table-base mt-3">
                    <thead><tr><th>Judul</th><th class="text-right">Peminjaman</th></tr></thead>
                    <tbody>
                        @foreach ($topBooks as $book)
                            <tr>
                                <td><p class="font-medium">{{ $book->title }}</p><p class="text-xs text-muted">{{ $book->authorNames() }}</p></td>
                                <td class="text-right font-semibold">{{ $book->borrowings_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="panel">
            <h2 class="font-display text-lg font-semibold">Peminjaman per kategori</h2>
            <ul class="mt-4 space-y-3">
                @foreach ($byCategory as $category)
                    @php $max = max(1, $byCategory->max('books_count')); @endphp
                    <li>
                        <div class="flex justify-between text-xs"><span class="font-medium">{{ $category->name }}</span><span class="text-muted">{{ $category->books_count }}</span></div>
                        <div class="mt-1 h-1.5 rounded-full bg-primary-ghost">
                            <div class="h-full rounded-full bg-accent" style="width: {{ round($category->books_count / $max * 100) }}%"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layouts.admin>
