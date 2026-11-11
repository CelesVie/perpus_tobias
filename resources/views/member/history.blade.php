<x-layouts.member title="Riwayat & denda">
    <h1 class="font-display text-2xl font-semibold">Riwayat & denda</h1>
    <p class="mt-1 text-sm text-muted">Catatan peminjaman yang sudah selesai dan denda yang tercatat.</p>

    <section class="mt-6">
        <h2 class="text-sm font-bold tracking-wide uppercase">Denda</h2>
        <div class="mt-3 card overflow-x-auto">
            @if ($fines->isEmpty())
                <div class="p-6"><x-empty-state title="Tidak ada denda" icon="receipt" /></div>
            @else
                <table class="table-base min-w-[560px]">
                    <thead><tr><th>Buku</th><th>Hari terlambat</th><th>Jumlah</th><th>Status</th><th>Dibayar</th></tr></thead>
                    <tbody>
                        @foreach ($fines as $fine)
                            <tr>
                                <td class="font-medium">{{ $fine->borrowing?->book?->title ?? '—' }}</td>
                                <td>{{ $fine->days_late }} hari</td>
                                <td class="font-semibold">Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                                <td><x-status-badge :status="$fine->status->value" /></td>
                                <td class="text-xs text-muted">{{ $fine->paid_at?->translatedFormat('d M Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>

    <section class="mt-8">
        <h2 class="text-sm font-bold tracking-wide uppercase">Riwayat peminjaman</h2>
        <div class="mt-3 card overflow-x-auto">
            @if ($borrowings->isEmpty())
                <div class="p-6"><x-empty-state title="Belum ada riwayat" icon="rotate-ccw" /></div>
            @else
                <table class="table-base min-w-[620px]">
                    <thead><tr><th>Buku</th><th>Dipinjam</th><th>Dikembalikan</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($borrowings as $borrowing)
                            <tr>
                                <td>
                                    <p class="font-medium">{{ $borrowing->book->title }}</p>
                                    <p class="text-xs text-muted">{{ $borrowing->code }}</p>
                                </td>
                                <td class="text-xs text-muted">{{ $borrowing->approved_at?->translatedFormat('d M Y') ?? '—' }}</td>
                                <td class="text-xs text-muted">{{ $borrowing->returned_at?->translatedFormat('d M Y') ?? '—' }}</td>
                                <td><x-status-badge :status="$borrowing->status" /></td>
                                <td class="text-right"><a href="{{ route('member.borrowings.show', $borrowing) }}" class="btn-ghost btn-sm">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-line px-4 py-3">{{ $borrowings->links() }}</div>
            @endif
        </div>
    </section>
</x-layouts.member>
