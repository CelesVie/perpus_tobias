<x-layouts.admin title="Penerbit" heading="Penerbit">
    <h1 class="font-display text-2xl font-semibold">Penerbit</h1>
    <p class="mt-1 text-sm text-muted">Daftar penerbit untuk metadata buku.</p>

    <div class="mt-5 grid gap-5 lg:grid-cols-[1fr_340px]">
        <div class="card overflow-x-auto">
            @if ($publishers->isEmpty())
                <div class="p-6"><x-empty-state title="Belum ada penerbit" icon="library" /></div>
            @else
                <table class="table-base min-w-[440px]">
                    <thead><tr><th>Nama</th><th>Kota</th><th>Buku</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($publishers as $publisher)
                            <tr x-data="{ edit: false }">
                                <td class="font-semibold">{{ $publisher->name }}</td>
                                <td class="text-xs text-muted">{{ $publisher->city ?: '—' }}</td>
                                <td>{{ $publisher->books_count }}</td>
                                <td class="text-right">
                                    <div class="inline-flex gap-1">
                                        <button class="btn-outline btn-sm" @click="edit = true">Ubah</button>
                                        <form method="POST" action="{{ route('admin.publishers.destroy', $publisher) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger btn-sm" type="submit"><x-icon name="trash-2" class="size-4" /></button>
                                        </form>
                                    </div>

                                    <div x-show="edit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-primary/50 p-4 text-left">
                                        <div class="w-full max-w-md rounded-xl bg-surface p-5" @click.outside="edit = false">
                                            <div class="flex items-center justify-between">
                                                <h2 class="font-display text-lg font-semibold">Ubah penerbit</h2>
                                                <button @click="edit = false" aria-label="Tutup"><x-icon name="x" class="size-5" /></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.publishers.update', $publisher) }}" class="mt-4 space-y-4">
                                                @csrf @method('PATCH')
                                                <div><label class="label">Nama</label><input name="name" value="{{ $publisher->name }}" required class="field"></div>
                                                <div><label class="label">Kota</label><input name="city" value="{{ $publisher->city }}" class="field"></div>
                                                <button class="btn-primary w-full" type="submit">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-line px-4 py-3">{{ $publishers->links() }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.publishers.store') }}" class="panel h-fit space-y-4">
            @csrf
            <h2 class="font-display text-lg font-semibold">Penerbit baru</h2>
            <div><label class="label" for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="field @error('name') field-error @enderror">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div><label class="label" for="city">Kota</label><input id="city" name="city" value="{{ old('city') }}" class="field"></div>
            <button class="btn-primary w-full" type="submit"><x-icon name="plus" class="size-4" /> Tambah</button>
        </form>
    </div>
</x-layouts.admin>
