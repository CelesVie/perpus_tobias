<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\CatalogMetadataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::query()->withCount('books')->orderBy('name')->paginate(15),
        ]);
    }

    public function store(CategoryRequest $request, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->createCategory($request->validated());

        return back()->with('status', 'Kategori ditambahkan.');
    }

    public function update(CategoryRequest $request, Category $category, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->updateCategory($category, $request->validated());

        return back()->with('status', 'Kategori diperbarui.');
    }

    public function destroy(Category $category, CatalogMetadataService $metadata): RedirectResponse
    {
        try {
            $metadata->deleteCategory($category);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return back()->with('status', 'Kategori dihapus.');
    }
}
