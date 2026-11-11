<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('public.about', [
            'titles' => Book::query()->count(),
            'members' => User::query()->where('role', 'member')->count(),
        ]);
    }
}
