<x-layouts.admin :title="'Peminjaman '.$borrowing->code" heading="Proses peminjaman">
    <a href="{{ route('admin.borrowings.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-ink">
        <x-icon name="chevron-left" class="size-4" /> Daftar peminjaman
    </a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="font-mono text-xs text-muted">{{ $borrowing->code }}</p>
            <h1 class="mt-1 font-display text-2xl font-semibold">{{ $borrowing->book?->title }}</h1>
        </div>
        <x-status-badge :status="$borrowing->status" class="!px-3 !py-1.5" />
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-[1.3fr_0.7fr]">
        <div class="space-y-5">
            <div class="panel">
                <h2 class="text-xs font-bold tracking-widest uppercase">Buku</h2>
                <div class="mt-3 flex gap-4">
                    <x-book-cover :book="$borrowing->book" class="h-28 w-20 rounded-md" />
                    <div class="text-sm">
                        <p class="font-semibold">{{ $borrowing->book?->title }}</p>
                        <p class="mt-1 text-muted">{{ $borrowing->book?->authorNames() }}</p>
                        <p class="mt-1 text-xs text-muted">{{ $borrowing->book?->publisher?->name }} &middot; {{ $borrowing->book?->publication_year }}</p>
                        <p class="mt-2 text-xs">
                            Stok: <span class="font-semibold">{{ $borrowing->book?->available_copies }}</span> dari {{ $borrowing->book?->total_copies }} eksemplar
                        </p>
                    </div>
                </div>

                @if ($borrowing->member_note)
                    <div class="mt-4 rounded-lg bg-paper p-3 text-sm">
                        <p class="text-xs font-semibold tracking-wide text-muted uppercase">Catatan anggota</p>
                        <p class="mt-1">{{ $borrowing->member_note }}</p>
                    </div>
                @endif

                @if ($borrowing->reject_reason)
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                        <p class="text-xs font-semibold uppercase">Alasan penolakan</p>
                        <p class="mt-1">{{ $borrowing->reject_reason }}</p>
                    </div>
                @endif
            </div>

            <div class="panel">
                <h2 class="text-xs font-bold tracking-widest uppercase">Tindakan</h2>

                @if ($borrowing->status === 'requested')
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}" class="space-y-2">
                            @csrf @method('PATCH')
                            <button class="btn-primary w-full" type="submit">
                                <x-icon name="check" class="size-4" /> Setujui peminjaman
                            </button>
                            <p class="help">Jatuh tempo {{ \App\Models\Setting::getInt('loan_duration_days') }} hari sejak hari ini.</p>
                        </form>

                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}" class="space-y-2">
                            @csrf @method('PATCH')
                            <input name="reject_reason" required class="field @error('reject_reason') field-error @enderror"
                                   placeholder="Alasan penolakan" value="{{ old('reject_reason') }}">
                            @error('reject_reason') <p class="error">{{ $message }}</p> @enderror
                            <button class="btn-danger w-full" type="submit"><x-icon name="circle-x" class="size-4" /> Tolak permohonan</button>
                        </form>
                    </div>
                @elseif ($borrowing->status === 'approved')
                    <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="mt-4">
                        @csrf @method('PATCH')
                        <button class="btn-accent" type="submit"><x-icon name="undo-2" class="size-4" /> Proses pengembalian</button>
                        <p class="help">
                            @if ($borrowing->isOverdue())
                                Terlambat {{ $borrowing->daysLate() }} hari. Denda dihitung Rp{{ number_format(\App\Models\Setting::getInt('fine_per_day'), 0, ',', '.') }} per hari.
                            @else
                                Belum melewati jatuh tempo, tidak ada denda.
                            @endif
                        </p>
                    </form>
                @else
                    <p class="mt-3 text-sm text-muted">Transaksi ini sudah selesai. Tidak ada tindakan lanjutan.</p>
                @endif
            </div>
        </div>

        <dl class="panel h-fit space-y-3 text-sm">
            <div class="flex justify-between gap-3"><dt class="text-muted">Anggota</dt>
                <dd class="text-right">
                    <a href="{{ route('admin.members.show', $borrowing->user) }}" class="font-medium hover:text-accent">{{ $borrowing->user?->name }}</a>
                    <p class="text-xs text-muted">{{ $borrowing->user?->email }}</p>
                </dd>
            </div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Diajukan</dt><dd>{{ $borrowing->requested_at->translatedFormat('d M Y H:i') }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Disetujui</dt><dd>{{ $borrowing->approved_at?->translatedFormat('d M Y H:i') ?? '—' }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Jatuh tempo</dt><dd>{{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Dikembalikan</dt><dd>{{ $borrowing->returned_at?->translatedFormat('d M Y') ?? '—' }}</dd></div>
            <div class="flex justify-between gap-3"><dt class="text-muted">Diproses oleh</dt><dd>{{ $borrowing->handler?->name ?? '—' }}</dd></div>

            @if ($borrowing->fine)
                <div class="mt-2 rounded-lg border border-red-200 bg-red-50 p-3">
                    <p class="text-xs font-semibold uppercase text-red-800">Denda</p>
                    <p class="mt-1 font-semibold text-red-800">Rp{{ number_format($borrowing->fine->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-red-700">{{ $borrowing->fine->days_late }} hari terlambat</p>
                    <div class="mt-2 flex items-center gap-2">
                        <x-status-badge :status="$borrowing->fine->status->value" />
                        @if ($borrowing->fine->status->value === 'unpaid')
                            <form method="POST" action="{{ route('admin.fines.pay', $borrowing->fine) }}">
                                @csrf @method('PATCH')
                                <button class="btn-ghost btn-sm" type="submit">Tandai lunas</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </dl>
    </div>
</x-layouts.admin>
