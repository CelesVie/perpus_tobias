<x-layouts.admin title="Pengembalian" heading="Pengembalian">
    <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Pengembalian</h1>
    <p class="eyebrow mt-4">Proses pengembalian buku aktif dan pantau keterlambatan.</p>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-1.5 text-xs">
            @foreach (['approved' => 'Dipinjam ('.$counts['approved'].')', 'terlambat' => 'Terlambat ('.$counts['overdue'].')', 'returned' => 'Dikembalikan ('.$counts['returned'].')', 'semua' => 'Semua'] as $value => $label)
                <a href="{{ route('admin.returns.index', ['status' => $value]) }}"
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
            <div class="p-6"><x-empty-state title="Tidak ada buku pada filter ini" description="Pinjaman aktif akan muncul di sini untuk diproses pengembaliannya." icon="undo-2" /></div>
        @else
            <table class="table-base min-w-[880px]">
                <thead><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Jatuh tempo</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td class="font-mono text-xs">{{ $borrowing->code }}</td>
                            <td>
                                <p class="font-medium">{{ $borrowing->user?->name }}</p>
                                <p class="truncate text-xs text-muted">{{ $borrowing->user?->email }}</p>
                            </td>
                            <td class="max-w-[200px]"><p class="truncate font-medium">{{ $borrowing->book?->title }}</p></td>
                            <td class="text-xs">
                                <p class="{{ $borrowing->isOverdue() ? 'font-semibold text-red-700' : 'text-muted' }}">
                                    {{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}
                                </p>
                                @if ($borrowing->isOverdue())
                                    <p class="mt-0.5 font-semibold text-red-700">
                                        Telat {{ $borrowing->daysLate() }} hari
                                    </p>
                                    <p class="text-red-700">
                                        Estimasi denda Rp{{ number_format($borrowing->daysLate() * $finePerDay, 0, ',', '.') }}
                                    </p>
                                @elseif ($borrowing->returned_at)
                                    <p class="mt-0.5 text-muted">Kembali {{ $borrowing->returned_at->translatedFormat('d M Y') }}</p>
                                @else
                                    <p class="mt-0.5 text-muted">Belum jatuh tempo</p>
                                @endif
                            </td>
                            <td><x-status-badge :status="$borrowing->status" /></td>
                            <td class="text-right">
                                @if ($borrowing->status === \App\Enums\BorrowingStatus::Approved->value)
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.borrowings.show', ['borrowing' => $borrowing, 'from' => 'returns']) }}" class="btn-ghost btn-sm">Detail</a>
                                        <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}"
                                              x-data="{ confirm: false }" @submit="confirm || ($event.preventDefault(), confirm = true)">
                                            @csrf @method('PATCH')
                                            <button class="btn-accent btn-sm uppercase" type="submit" x-show="!confirm">Proses kembali</button>
                                            <button class="btn-danger btn-sm uppercase" type="submit" x-show="confirm" x-cloak>Yakin proses?</button>
                                        </form>
                                    </div>
                                @else
                                    <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="btn-outline btn-sm">Detail</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-line px-4 py-3">{{ $borrowings->links() }}</div>
        @endif
    </div>
</x-layouts.admin>