<x-layouts.public :title="$category->name" :description="$category->description">
    <x-page-header :name="$category->name" :title="$category->name" :description="$category->description" />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        @if ($books->isEmpty())
            <x-empty-state title="Belum ada buku di kategori ini" icon="book-open">
                <x-slot:action>
                    <a href="{{ route('books.index') }}" class="btn-outline btn-sm">Lihat katalog</a>
                </x-slot:action>
            </x-empty-state>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
            <div class="mt-8">{{ $books->links() }}</div>
        @endif
    </div>
</x-layouts.public>
