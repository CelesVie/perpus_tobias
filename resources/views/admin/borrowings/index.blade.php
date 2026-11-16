<x-layouts.admin title="Peminjaman" heading="Peminjaman">
    <h1 class="font-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">Peminjaman</h1>
    <p class="eyebrow mt-4">Kelola pengajuan peminjaman buku dari anggota.</p>

    @if ($errors->any())
        <div class="mt-5 border border-red-700 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-1.5 text-xs">
            @foreach (['requested' => 'Menunggu ('.$counts['requested'].')', 'approved' => 'Dipinjam ('.$counts['approved'].')', 'ditolak' => 'Ditolak / Dibatalkan ('.$counts['ditolak'].')', 'semua' => 'Semua'] as $value => $label)
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
            <div class="p-6"><x-empty-state title="Tidak ada pengajuan pada filter ini" description="Permohonan baru dari anggota akan muncul di sini." icon="clipboard-list" /></div>
        @else
            <table class="table-base min-w-[820px]">
                <thead><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Diajukan</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td class="font-mono text-xs">{{ $borrowing->code }}</td>
                            <td>
                                <p class="font-medium">{{ $borrowing->user?->name }}</p>
                                <p class="truncate text-xs text-muted">{{ $borrowing->user?->email }}</p>
                            </td>
                            <td class="max-w-[220px]">
                                <p class="truncate font-medium">{{ $borrowing->book?->title }}</p>
                                @if ($borrowing->member_note)
                                    <p class="truncate text-xs text-muted">“{{ $borrowing->member_note }}”</p>
                                @endif
                            </td>
                            <td class="text-xs text-muted">{{ $borrowing->requested_at->translatedFormat('d M Y') }}</td>
                            <td><x-status-badge :status="$borrowing->status" /></td>
                            <td class="text-right">
                                @if ($borrowing->status === \App\Enums\BorrowingStatus::Requested->value)
                                    <div class="inline-flex flex-wrap items-start justify-end gap-1.5">
                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn-primary btn-sm" type="submit">Setujui</button>
                                        </form>

                                        <div x-data="{ rejecting: false }" class="text-left">
                                            <button type="button" @click="rejecting = true" x-show="!rejecting" class="btn-danger btn-sm">
                                                Tolak
                                            </button>
                                            <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}" x-show="rejecting" x-cloak
                                                  class="flex items-start gap-1.5">
                                                @csrf @method('PATCH')
                                                <input name="reject_reason" required placeholder="Alasan penolakan"
                                                       class="field !w-44 !py-1.5 text-xs" value="{{ old('reject_reason') }}">
                                                <button class="btn-danger btn-sm" type="submit">Kirim</button>
                                                <button type="button" @click="rejecting = false" class="btn-ghost btn-sm">Batal</button>
                                            </form>
                                        </div>
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