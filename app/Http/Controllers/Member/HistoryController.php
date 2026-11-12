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
                ->with(['book.authors', 'fine'])
                ->whereIn('status', ['returned', 'rejected', 'cancelled'])
                ->latest('updated_at')
                ->paginate(10),
            'fines' => $request->user()->fines()
                ->with('borrowing.book')
                ->latest()
                ->paginate(10, ['*'], 'fines')
                ->withQueryString(),
        ]);
    }
}
