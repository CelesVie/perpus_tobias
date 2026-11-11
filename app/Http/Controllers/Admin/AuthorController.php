<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorRequest;
use App\Models\Author;
use App\Services\CatalogMetadataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        return view('admin.authors.index', [
            'authors' => Author::query()->withCount('books')->orderBy('name')->paginate(15),
        ]);
    }

    public function store(AuthorRequest $request, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->createAuthor($request->validated());

        return back()->with('status', 'Penulis ditambahkan.');
    }

    public function update(AuthorRequest $request, Author $author, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->updateAuthor($author, $request->validated());

        return back()->with('status', 'Data penulis diperbarui.');
    }

    public function destroy(Author $author, CatalogMetadataService $metadata): RedirectResponse
    {
        try {
            $metadata->deleteAuthor($author);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return back()->with('status', 'Penulis dihapus.');
    }
}
