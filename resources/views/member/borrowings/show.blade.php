<x-layouts.member :title="'Peminjaman '.$borrowing->code">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-xs font-mono text-muted">{{ $borrowing->code }}</p>
            <h1 class="mt-1 font-display text-2xl font-semibold">Detail peminjaman</h1>
        </div>
        <x-status-badge :status="$borrowing->status" class="!px-3 !py-1.5" />
    </div>

    <div class="mt-6 grid gap-5 lg:grid-cols-[1.3fr_0.7fr]">
        <div class="panel">
            <div class="flex gap-4">
                <x-book-cover :book="$borrowing->book" class="h-28 w-20 rounded-md" />
                <div>
                    <a href="{{ route('member.books.show', $borrowing->book) }}" class="font-display text-lg font-semibold hover:text-accent">
                        {{ $borrowing->book->title }}
                    </a>
                    <p class="mt-1 text-sm text-muted">{{ $borrowing->book->authorNames() }}</p>
                    <p class="mt-2 text-xs text-muted">{{ $borrowing->book->publisher?->name }}</p>
                </div>
            </div>

            @if ($borrowing->member_note)
                <div class="mt-5 rounded-lg bg-paper p-3 text-sm">
                    <p class="text-xs font-semibold tracking-wide text-muted uppercase">Catatan Anda</p>
                    <p class="mt-1">{{ $borrowing->member_note }}</p>
                </div>
            @endif

            @if ($borrowing->reject_reason)
                <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                    <p class="text-xs font-semibold tracking-wide uppercase">Alasan penolakan</p>
                    <p class="mt-1">{{ $borrowing->reject_reason }}</p>
                </div>
            @endif

            @if ($borrowing->status === 'requested')
                <form method="POST" action="{{ route('member.borrowings.cancel', $borrowing) }}" class="mt-6"
                      x-data="{ confirm: false }" @submit="confirm || ($event.preventDefault(), confirm = true)">
                    @csrf @method('PATCH')
                    <button class="btn-danger btn-sm" type="submit" x-show="!confirm">Batalkan permohonan</button>
                    <div x-show="confirm" x-cloak class="flex flex-wrap items-center gap-2 text-sm">
                        <span>Yakin membatalkan?</span>
                        <button class="btn-danger btn-sm" type="submit">Ya, batalkan</button>
                        <button class="btn-ghost btn-sm" type="button" @click="confirm = false">Tidak</button>
                    </div>
                </form>
            @endif
        </div>

        <dl class="panel space-y-3 text-sm">
            <div class="flex justify-between gap-3"><dt class="text-muted">Diajukan</dt><dd>{{ $borrowing->requested_at->translatedFormat('d M Y H:i') }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Disetujui</dt><dd>{{ $borrowing->approved_at?->translatedFormat('d M Y H:i') ?? '—' }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Jatuh tempo</dt>
                <dd class="{{ $borrowing->isOverdue() ? 'font-semibold text-red-600' : '' }}">
                    {{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}
                </dd>
            </div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Dikembalikan</dt><dd>{{ $borrowing->returned_at?->translatedFormat('d M Y') ?? '—' }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Diproses oleh</dt><dd>{{ $borrowing->handler?->name ?? '—' }}</dd></div>

            @if ($borrowing->fine)
                <div class="mt-3 rounded-lg border border-red-200 bg-red-50 p-3">
                    <p class="text-xs font-semibold tracking-wide text-red-800 uppercase">Denda</p>
                    <p class="mt-1 font-semibold text-red-800">Rp{{ number_format($borrowing->fine->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-red-700">{{ $borrowing->fine->days_late }} hari terlambat</p>
                    <div class="mt-2"><x-status-badge :status="$borrowing->fine->status->value" /></div>
                </div>
            @elseif ($borrowing->isOverdue())
                <p class="mt-3 rounded-lg bg-amber-50 p-3 text-xs text-amber-800">
                    Terlambat {{ $borrowing->daysLate() }} hari. Denda belum diterbitkan sampai buku dikembalikan.
                </p>
            @endif

            <a href="{{ route('member.borrowings.index') }}" class="btn-outline btn-sm mt-3 w-full">Kembali</a>
        </dl>
    </div>
</x-layouts.member>
