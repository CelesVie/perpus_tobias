<x-layouts.admin title="Penulis" heading="Penulis">
    <h1 class="font-display text-2xl font-semibold">Penulis</h1>
    <p class="mt-1 text-sm text-muted">Data penulis dipakai saat menambah buku.</p>

    <div class="mt-5 grid gap-5 lg:grid-cols-[1fr_340px]">
        <div class="card overflow-x-auto">
            @if ($authors->isEmpty())
                <div class="p-6"><x-empty-state title="Belum ada penulis" icon="pencil" /></div>
            @else
                <table class="table-base min-w-[480px]">
                    <thead><tr><th>Nama</th><th>Buku</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($authors as $author)
                            <tr x-data="{ edit: false }">
                                <td>
                                    <p class="font-semibold">{{ $author->name }}</p>
                                    <p class="max-w-xs truncate text-xs text-muted">{{ $author->bio }}</p>
                                </td>
                                <td>{{ $author->books_count }}</td>
                                <td class="text-right">
                                    <div class="inline-flex gap-1">
                                        <button class="btn-outline btn-sm" @click="edit = true">Ubah</button>
                                        <form method="POST" action="{{ route('admin.authors.destroy', $author) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger btn-sm" type="submit"><x-icon name="trash-2" class="size-4" /></button>
                                        </form>
                                    </div>

                                    <div x-show="edit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-primary/50 p-4 text-left">
                                        <div class="w-full max-w-md rounded-xl bg-surface p-5" @click.outside="edit = false">
                                            <div class="flex items-center justify-between">
                                                <h2 class="font-display text-lg font-semibold">Ubah penulis</h2>
                                                <button @click="edit = false" aria-label="Tutup"><x-icon name="x" class="size-5" /></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.authors.update', $author) }}" class="mt-4 space-y-4">
                                                @csrf @method('PATCH')
                                                <div><label class="label">Nama</label><input name="name" value="{{ $author->name }}" required class="field"></div>
                                                <div><label class="label">Bio singkat</label><textarea name="bio" rows="3" class="field">{{ $author->bio }}</textarea></div>
                                                <button class="btn-primary w-full" type="submit">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-line px-4 py-3">{{ $authors->links() }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.authors.store') }}" class="panel h-fit space-y-4">
            @csrf
            <h2 class="font-display text-lg font-semibold">Penulis baru</h2>
            <div><label class="label" for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="field @error('name') field-error @enderror">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div><label class="label" for="bio">Bio singkat</label>
                <textarea id="bio" name="bio" rows="3" class="field">{{ old('bio') }}</textarea>
            </div>
            <button class="btn-primary w-full" type="submit"><x-icon name="plus" class="size-4" /> Tambah</button>
        </form>
    </div>
</x-layouts.admin>
