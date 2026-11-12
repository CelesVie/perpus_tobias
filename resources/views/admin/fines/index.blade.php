<x-layouts.admin title="Denda" heading="Denda">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Denda</h1>
            <p class="eyebrow mt-4">Denda otomatis untuk pengembalian terlambat.</p>
        </div>
        <div class="border-y border-black px-4 py-2.5 text-sm">
            <p class="eyebrow">Belum dibayar</p>
            <p class="font-display text-2xl font-bold">Rp{{ number_format($totalUnpaid, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-1.5 text-xs">
        @foreach (['unpaid' => 'Belum dibayar', 'paid' => 'Lunas', 'semua' => 'Semua'] as $value => $label)
            <a href="{{ route('admin.fines.index', ['status' => $value]) }}"
               class="rounded-none border border-black px-3 py-1.5 font-sans text-[10px] font-semibold tracking-widest uppercase {{ $status === $value ? 'bg-black text-white' : 'bg-white text-muted hover:text-black' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="mt-4 card overflow-x-auto">
        @if ($fines->isEmpty())
            <div class="p-6"><x-empty-state title="Tidak ada denda" icon="receipt" /></div>
        @else
            <table class="table-base min-w-[700px]">
                <thead><tr><th>Anggota</th><th>Buku</th><th>Hari</th><th>Jumlah</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($fines as $fine)
                        <tr>
                            <td>
                                <p class="font-medium">{{ $fine->user?->name }}</p>
                                <p class="text-xs text-muted">{{ $fine->borrowing?->code }}</p>
                            </td>
                            <td class="max-w-[220px]"><p class="truncate">{{ $fine->borrowing?->book?->title }}</p></td>
                            <td>{{ $fine->days_late }} hari</td>
                            <td class="font-semibold">Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                            <td><x-status-badge :status="$fine->status->value" /></td>
                            <td class="text-right">
                                @if ($fine->status->value === 'unpaid')
                                    <form method="POST" action="{{ route('admin.fines.pay', $fine) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn-outline btn-sm" type="submit">Tandai lunas</button>
                                    </form>
                                @else
                                    <span class="text-xs text-muted">{{ $fine->paid_at?->translatedFormat('d M Y') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-line px-4 py-3">{{ $fines->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
