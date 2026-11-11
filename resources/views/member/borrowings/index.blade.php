<x-layouts.member title="Peminjaman saya">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-semibold">Peminjaman saya</h1>
            <p class="mt-1 text-sm text-muted">Pantau status permohonan dan jatuh tempo.</p>
        </div>
        <div class="flex flex-wrap gap-1.5 text-xs">
            @foreach (['' => 'Semua', 'requested' => 'Menunggu', 'approved' => 'Dipinjam', 'returned' => 'Selesai'] as $value => $label)
                <a href="{{ route('member.borrowings.index', $value === '' ? [] : ['status' => $value]) }}"
                   class="rounded-lg border px-3 py-1.5 font-semibold {{ $status === ($value ?: null) ? 'border-primary bg-primary text-white' : 'border-line bg-surface text-muted hover:text-ink' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-6 card overflow-x-auto">
        @if ($borrowings->isEmpty())
            <div class="p-6"><x-empty-state title="Belum ada peminjaman" icon="clipboard-list" description="Ajukan peminjaman dari katalog buku." /></div>
        @else
            <table class="table-base min-w-[640px]">
                <thead>
                    <tr>
                        <th>Buku</th><th>Diajukan</th><th>Jatuh tempo</th><th>Status</th><th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td>
                                <a href="{{ route('member.borrowings.show', $borrowing) }}" class="font-semibold hover:text-accent">{{ $borrowing->book->title }}</a>
                                <p class="text-xs text-muted">{{ $borrowing->code }}</p>
                            </td>
                            <td class="text-xs text-muted">{{ $borrowing->requested_at->translatedFormat('d M Y') }}</td>
                            <td class="text-xs {{ $borrowing->isOverdue() ? 'font-semibold text-red-600' : 'text-muted' }}">
                                {{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}
                            </td>
                            <td><x-status-badge :status="$borrowing->status" /></td>
                            <td class="text-right">
                                <a href="{{ route('member.borrowings.show', $borrowing) }}" class="btn-ghost btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-line px-4 py-3">{{ $borrowings->links() }}</div>
        @endif
    </div>
</x-layouts.member>
