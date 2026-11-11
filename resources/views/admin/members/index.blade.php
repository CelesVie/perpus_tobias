<x-layouts.admin title="Anggota" heading="Anggota">
    <h1 class="font-display text-2xl font-semibold">Anggota</h1>
    <p class="mt-1 text-sm text-muted">Kelola akun anggota perpustakaan.</p>

    <form method="GET" class="mt-5 flex max-w-md gap-2">
        <input name="q" value="{{ $term }}" class="field" placeholder="Cari nama atau email" aria-label="Cari anggota">
        <button class="btn-outline" type="submit"><x-icon name="search" class="size-4" /> Cari</button>
    </form>

    <div class="mt-5 card overflow-x-auto">
        @if ($members->isEmpty())
            <div class="p-6"><x-empty-state title="Anggota tidak ditemukan" icon="users" /></div>
        @else
            <table class="table-base min-w-[640px]">
                <thead><tr><th>Nama</th><th>Kontak</th><th>Aktif</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                <p class="font-semibold">{{ $member->name }}</p>
                                <p class="text-xs text-muted">Bergabung {{ $member->joined_at?->translatedFormat('M Y') ?? '—' }}</p>
                            </td>
                            <td class="text-xs">
                                <p>{{ $member->email }}</p>
                                <p class="text-muted">{{ $member->phone ?: '—' }}</p>
                            </td>
                            <td>{{ $member->active_loans_count }}</td>
                            <td>
                                <span class="badge {{ $member->is_active ? 'bg-accent-soft text-accent' : 'bg-red-50 text-red-600' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex gap-1">
                                    <a href="{{ route('admin.members.show', $member) }}" class="btn-outline btn-sm">Detail</a>
                                    <form method="POST" action="{{ route('admin.members.toggle', $member) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn-ghost btn-sm" type="submit">{{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-line px-4 py-3">{{ $members->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
