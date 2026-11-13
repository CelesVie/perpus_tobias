@php $editing = $book->exists; @endphp

<x-layouts.admin :title="$editing ? 'Ubah buku' : 'Tambah buku'" :heading="$editing ? 'Ubah buku' : 'Tambah buku'">
    <div class="max-w-3xl">
        <p class="font-sans text-[10px] font-semibold tracking-[0.15em] text-muted uppercase">Koleksi / Metadata</p>
        <h1 class="mt-3 font-serif-display text-5xl font-bold leading-none tracking-tight sm:text-7xl">{{ $editing ? 'Ubah buku' : 'Tambah buku baru' }}</h1>
        <p class="mt-5 text-base text-muted">
            {{ $editing ? 'Perbarui metadata koleksi. Eksemplar tersedia dihitung ulang otomatis.' : 'Lengkapi metadata buku sebelum menyimpan.' }}
        </p>

        <form method="POST" action="{{ $editing ? route('admin.books.update', $book) : route('admin.books.store') }}"
              enctype="multipart/form-data" class="mt-8 space-y-7 border-y border-black py-6">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <label class="label" for="title">Judul</label>
                <input id="title" name="title" value="{{ old('title', $book->title) }}" required
                       class="field @error('title') field-error @enderror">
                @error('title') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" required class="field @error('category_id') field-error @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id', $book->category_id) === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="publisher_id">Penerbit</label>
                    <select id="publisher_id" name="publisher_id" class="field @error('publisher_id') field-error @enderror">
                        <option value="">Tanpa penerbit</option>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}" @selected((int) old('publisher_id', $book->publisher_id) === $publisher->id)>{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                    @error('publisher_id') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <fieldset class="border-y border-black py-4">
                <legend class="label">Penulis</legend>
                @php $selectedAuthors = collect(old('author_ids', $book->authors->pluck('id')->all()))->map(fn ($id) => (int) $id); @endphp
                <div class="max-h-44 space-y-1 overflow-y-auto border border-black p-3">
                    @foreach ($authors as $author)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="author_ids[]" value="{{ $author->id }}"
                                   @checked($selectedAuthors->contains($author->id))
                                   class="size-4 rounded-none border-black text-black focus:ring-black">
                            {{ $author->name }}
                        </label>
                    @endforeach
                </div>
                @error('author_ids') <p class="error">{{ $message }}</p> @enderror
            </fieldset>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label class="label" for="isbn">ISBN</label>
                    <input id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="field @error('isbn') field-error @enderror">
                    @error('isbn') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="publication_year">Tahun terbit</label>
                    <input id="publication_year" name="publication_year" type="number" value="{{ old('publication_year', $book->publication_year) }}"
                           class="field @error('publication_year') field-error @enderror">
                    @error('publication_year') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="page_count">Halaman</label>
                    <input id="page_count" name="page_count" type="number" value="{{ old('page_count', $book->page_count) }}"
                           class="field @error('page_count') field-error @enderror">
                    @error('page_count') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="total_copies">Jumlah eksemplar</label>
                    <input id="total_copies" name="total_copies" type="number" min="1" value="{{ old('total_copies', $book->total_copies ?: 1) }}"
                           class="field @error('total_copies') field-error @enderror">
                    @error('total_copies') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="cover">Sampul buku</label>
                    <div class="flex items-start gap-4">
                        <div class="shrink-0">
                            <x-book-cover :book="$book" class="h-24 w-16" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <input id="cover" name="cover" type="file"
                                   accept="image/jpeg,image/png,image/webp"
                                   class="field @error('cover') field-error @enderror">
                            <p class="help mt-1.5">
                                {{ $book->coverUrl() ? 'Sampul terpasang: '.basename($book->cover_path).'. Unggah file baru untuk mengganti, atau biarkan kosong.'
                                    : 'JPG, PNG, atau WebP, maksimal 2 MB. Berkas tanpa sampul akan ditampilkan sebagai kotak bernotasi.'.'' }}
                            </p>
                        </div>
                    </div>
                    @error('cover') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="label" for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="field @error('description') field-error @enderror">{{ old('description', $book->description) }}</textarea>
                @error('description') <p class="error">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $book->is_featured))
                       class="size-4 rounded-none border-black text-black focus:ring-black">
                Tampilkan sebagai pilihan di beranda
            </label>

            <div class="flex gap-2 border-t border-line pt-5">
                <button class="btn-primary" type="submit">{{ $editing ? 'Simpan perubahan' : 'Simpan buku' }}</button>
                <a href="{{ route('admin.books.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
