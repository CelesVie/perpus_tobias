<x-layouts.admin title="Kategori" heading="Kategori">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-semibold">Kategori</h1>
            <p class="mt-1 text-sm text-muted">Kelompokkan koleksi agar mudah ditelusuri.</p>
        </div>
    </div>

    <div class="mt-5 grid gap-5 lg:grid-cols-[1fr_340px]">
        <div class="card overflow-x-auto">
            @if ($categories->isEmpty())
                <div class="p-6"><x-empty-state title="Belum ada kategori" icon="tags" /></div>
            @else
                <table class="table-base min-w-[520px]">
                    <thead><tr><th>Nama</th><th>Deskripsi</th><th>Buku</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr x-data="{ edit: false }">
                                <td class="font-semibold">{{ $category->name }}</td>
                                <td class="max-w-xs truncate text-xs text-muted">{{ $category->description }}</td>
                                <td>{{ $category->books_count }}</td>
                                <td class="text-right">
                                    <div class="inline-flex gap-1">
                                        <button class="btn-outline btn-sm" @click="edit = true">Ubah</button>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger btn-sm" type="submit"><x-icon name="trash-2" class="size-4" /></button>
                                        </form>
                                    </div>

                                    <div x-show="edit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-primary/50 p-4 text-left">
                                        <div class="w-full max-w-md rounded-xl bg-surface p-5" @click.outside="edit = false">
                                            <div class="flex items-center justify-between">
                                                <h2 class="font-display text-lg font-semibold">Ubah kategori</h2>
                                                <button @click="edit = false" aria-label="Tutup"><x-icon name="x" class="size-5" /></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-4 space-y-4">
                                                @csrf @method('PATCH')
                                                <div>
                                                    <label class="label">Nama</label>
                                                    <input name="name" value="{{ $category->name }}" required class="field">
                                                </div>
                                                <div>
                                                    <label class="label">Deskripsi</label>
                                                    <textarea name="description" rows="3" class="field">{{ $category->description }}</textarea>
                                                </div>
                                                <button class="btn-primary w-full" type="submit">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-line px-4 py-3">{{ $categories->links() }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="panel h-fit space-y-4">
            @csrf
            <h2 class="font-display text-lg font-semibold">Kategori baru</h2>
            <div>
                <label class="label" for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="field @error('name') field-error @enderror">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="label" for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="3" class="field">{{ old('description') }}</textarea>
                @error('description') <p class="error">{{ $message }}</p> @enderror
            </div>
            <button class="btn-primary w-full" type="submit"><x-icon name="plus" class="size-4" /> Tambah</button>
        </form>
    </div>
</x-layouts.admin>
