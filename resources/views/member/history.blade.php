<x-layouts.member title="Riwayat">
    <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Riwayat</h1>
    <p class="eyebrow mt-4">Catatan peminjaman yang sudah selesai.</p>

    <section class="mt-6">
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