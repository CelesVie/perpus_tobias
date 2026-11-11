<x-layouts.admin :title="$member->name" heading="Detail anggota">
    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-ink">
        <x-icon name="chevron-left" class="size-4" /> Daftar anggota
    </a>

    <div class="mt-4 grid gap-5 lg:grid-cols-[320px_1fr]">
        <div class="panel h-fit">
            <div class="flex items-center gap-3">
                <span class="grid size-12 place-items-center rounded-full bg-primary font-display text-lg font-semibold text-white">{{ $member->initials() }}</span>
                <div class="min-w-0">
                    <p class="truncate font-semibold">{{ $member->name }}</p>
                    <p class="truncate text-xs text-muted">{{ $member->email }}</p>
                </div>
            </div>
            <dl class="mt-4 space-y-2 border-t border-line pt-4 text-sm">
                <div class="flex justify-between"><dt class="text-muted">Telepon</dt><dd>{{ $member->phone ?: '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Alamat</dt><dd class="text-right">{{ $member->address ?: '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Bergabung</dt><dd>{{ $member->joined_at?->translatedFormat('d M Y') ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Status</dt>
                    <dd><span class="badge {{ $member->is_active ? 'bg-accent-soft text-accent' : 'bg-red-50 text-red-600' }}">{{ $member->is_active ? 'Aktif' : 'Nonaktif' }}</span></dd>
                </div>
            </dl>
            <form method="POST" action="{{ route('admin.members.toggle', $member) }}" class="mt-4">
                @csrf @method('PATCH')
                <button class="btn-outline btn-sm w-full" type="submit">{{ $member->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}</button>
            </form>
        </div>

        <div class="space-y-5">
            <div class="card overflow-x-auto">
                <div class="border-b border-line px-4 py-3"><h2 class="font-display text-lg font-semibold">Riwayat peminjaman</h2></div>
                @if ($borrowings->isEmpty())
                    <div class="p-6"><x-empty-state title="Belum ada peminjaman" icon="clipboard-list" /></div>
                @else
                    <table class="table-base min-w-[520px]">
                        <thead><tr><th>Buku</th><th>Diajukan</th><th>Jatuh tempo</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach ($borrowings as $borrowing)
                                <tr>
                                    <td><a href="{{ route('admin.borrowings.show', $borrowing) }}" class="font-medium hover:text-accent">{{ $borrowing->book?->title }}</a></td>
                                    <td class="text-xs text-muted">{{ $borrowing->requested_at->translatedFormat('d M Y') }}</td>
                                    <td class="text-xs">{{ $borrowing->due_at?->translatedFormat('d M Y') ?? '—' }}</td>
                                    <td><x-status-badge :status="$borrowing->status" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="border-t border-line px-4 py-3">{{ $borrowings->links() }}</div>
                @endif
            </div>

            <div class="card overflow-x-auto">
                <div class="border-b border-line px-4 py-3"><h2 class="font-display text-lg font-semibold">Denda</h2></div>
                @if ($fines->isEmpty())
                    <p class="p-4 text-sm text-muted">Tidak ada denda tercatat.</p>
                @else
                    <table class="table-base min-w-[480px]">
                        <thead><tr><th>Buku</th><th>Hari</th><th>Jumlah</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach ($fines as $fine)
                                <tr>
                                    <td>{{ $fine->borrowing?->book?->title ?? '—' }}</td>
                                    <td>{{ $fine->days_late }}</td>
                                    <td class="font-semibold">Rp{{ number_format($fine->amount, 0, ',', '.') }}</td>
                                    <td><x-status-badge :status="$fine->status->value" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
