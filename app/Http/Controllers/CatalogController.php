<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogIndexRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(CatalogIndexRequest $request): View
    {
        $filters = $request->validated();

        $books = Book::query()
            ->with(['authors', 'category', 'publisher'])
            ->search($filters['q'] ?? null)
            ->when($filters['kategori'] ?? null, fn (Builder $q, string $slug) => $q->whereHas(
                'category', fn (Builder $c) => $c->where('slug', $slug)
            ))
            ->when($filters['penulis'] ?? null, fn (Builder $q, int $id) => $q->whereHas(
                'authors', fn (Builder $a) => $a->whereKey($id)
            ))
            ->when($filters['penerbit'] ?? null, fn (Builder $q, int $id) => $q->where('publisher_id', $id))
            ->when($filters['tahun'] ?? null, fn (Builder $q, int $year) => $q->where('publication_year', $year))
            ->when(($filters['ketersediaan'] ?? null) === 'tersedia', fn (Builder $q) => $q->available())
            ->when(($filters['ketersediaan'] ?? null) === 'dipinjam', fn (Builder $q) => $q->where('available_copies', 0))
            ->when(($filters['urut'] ?? null) === 'populer', fn (Builder $q) => $q->withCount('borrowings')->orderByDesc('borrowings_count'))
            ->when(($filters['urut'] ?? null) === 'judul', fn (Builder $q) => $q->orderBy('title'))
            ->when(blank($filters['urut'] ?? null), fn (Builder $q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        return view('public.catalog.index', [
            'books' => $books,
            'filters' => $filters,
            'categories' => Category::query()->withCount('books')->orderBy('name')->get(),
            'authors' => Author::query()->orderBy('name')->get(),
            'publishers' => Publisher::query()->orderBy('name')->get(),
            'years' => Book::query()->whereNotNull('publication_year')
                ->distinct()->orderByDesc('publication_year')->pluck('publication_year'),
        ]);
    }

    public function show(Book $book): View
    {
        $book->load(['authors', 'category', 'publisher']);
        $book->increment('view_count');

        $related = Book::query()
            ->with(['authors', 'category'])
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->id)
            ->available()
            ->take(4)
            ->get();

        $activeBorrowing = auth()->check()
            ? $book->borrowings()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['requested', 'approved'])
                ->first()
            : null;

        return view('public.catalog.show', compact('book', 'related', 'activeBorrowing'));
    }
}
