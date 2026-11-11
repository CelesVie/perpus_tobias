<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookIndexRequest;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Services\BookCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(BookIndexRequest $request): View
    {
        $term = trim($request->validated('q') ?? '');

        return view('admin.books.index', [
            'books' => Book::query()
                ->with(['authors', 'category'])
                ->search($term)
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'term' => $term,
        ]);
    }

    public function create(): View
    {
        return view('admin.books.form', $this->formData(new Book));
    }

    public function store(BookRequest $request, BookCatalogService $catalog): RedirectResponse
    {
        $data = $this->payload($request);
        $data['author_ids'] = $request->validated('author_ids');
        $coverPath = $request->file('cover')?->store('covers', 'public');
        $catalog->create($data, $coverPath);

        return redirect()->route('admin.books.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        return view('admin.books.form', $this->formData($book));
    }

    public function update(BookRequest $request, Book $book, BookCatalogService $catalog): RedirectResponse
    {
        $data = $this->payload($request);
        $data['author_ids'] = $request->validated('author_ids');
        $coverPath = $request->file('cover')?->store('covers', 'public');
        $catalog->update($book, $data, $coverPath);

        return redirect()->route('admin.books.index')->with('status', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book, BookCatalogService $catalog): RedirectResponse
    {
        try {
            $catalog->delete($book);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return redirect()->route('admin.books.index')->with('status', 'Buku dihapus dari katalog.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Book $book): array
    {
        return [
            'book' => $book,
            'categories' => Category::query()->orderBy('name')->get(),
            'publishers' => Publisher::query()->orderBy('name')->get(),
            'authors' => Author::query()->orderBy('name')->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(BookRequest $request): array
    {
        $data = $request->safe()->except(['author_ids', 'cover']);

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
