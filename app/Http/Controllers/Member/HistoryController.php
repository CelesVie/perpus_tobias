<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('member.history', [
            'borrowings' => $request->user()->borrowings()
                ->with('book.authors')
                ->whereIn('status', ['returned', 'rejected', 'cancelled'])
                ->latest('updated_at')
                ->orderByDesc('id')
                ->paginate(10),
        ]);
    }
}
