<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'titles' => Book::query()->count(),
            'copies' => (int) Book::query()->sum('total_copies'),
            'members' => User::query()->where('role', UserRole::Member)->count(),
            'categories' => Category::query()->count(),
        ];

        $latest = Book::query()
            ->with(['authors', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $popular = Book::query()
            ->withCount('borrowings')
            ->with(['authors', 'category'])
            ->orderByDesc('borrowings_count')
            ->take(6)
            ->get();

        $categories = Category::query()
            ->withCount('books')
            ->orderByDesc('books_count')
            ->take(8)
            ->get();

        return view('public.home', compact('stats', 'latest', 'popular', 'categories'));
    }
}
