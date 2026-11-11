<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('public.categories.index', [
            'categories' => Category::query()->withCount('books')->orderBy('name')->get(),
        ]);
    }

    public function show(Category $category): View
    {
        return view('public.categories.show', [
            'category' => $category,
            'books' => $category->books()->with('authors')->latest()->paginate(12),
        ]);
    }
}
