<x-layouts.admin title="Peminjaman" heading="Peminjaman">
    <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Peminjaman</h1>
    <p class="eyebrow mt-4">Setujui, tolak, dan proses pengembalian buku.</p>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-1.5 text-xs">
            @foreach (['requested' => 'Menunggu ('.$counts['requested'].')', 'approved' => 'Dipinjam ('.$counts['approved'].')', 'terlambat' => 'Terlambat ('.$counts['terlambat'].')', 'semua' => 'Semua'] as $value => $label)
                <a href="{{ route('admin.borrowings.index', ['status' => $value]) }}"
                   class="rounded-none border border-black px-3 py-1.5 font-sans text-[10px] font-semibold tracking-widest uppercase {{ $status === $value ? 'bg-black text-white' : 'bg-white text-muted hover:text-black' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <form method="GET" class="flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input name="q" value="{{ $term }}" class="field !py-2 text-xs" placeholder="Kode, anggota, atau judul">
            <button class="btn-outline btn-sm" type="submit">Cari</button>
        </form>
    </div>

    <div class="mt-4 card overflow-x-auto">
        @if ($borrowings->isEmpty())
            <div class="p-6"><x-empty-state title="Tidak ada peminjaman pada filter ini" icon="clipboard-list" /></div>
        @else
            <table class="table-base min-w-[760px]">
                <thead><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Jatuh tempo</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td class="font-mono text-xs">{{ $borrowing->code }}</td>
                            <td>
                                <p class="font-medium">{{ $borrowing->user?->name }}</p>
                                <p class="text-xs text-muted">{{ $borrowing->requested_at->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="max-w-[220px]"><p class="truncate font-medium">{{ $borrowing->book?->title }}</p></td>
                            <td class="text-xs {{ $borrowing->isOverdue() ? 'font-semibold text-red-600' : 'text-muted' }}">
                                {{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}
                                @if ($borrowing->isOverdue())<br>{{ $borrowing->daysLate() }} hari @endif
                            </td>
                            <td><x-status-badge :status="$borrowing->status" /></td>
                            <td class="text-right"><a href="{{ route('admin.borrowings.show', $borrowing) }}" class="btn-outline btn-sm">Proses</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-line px-4 py-3">{{ $borrowings->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
