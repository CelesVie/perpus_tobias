<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $active = $user->borrowings()
            ->with('book.authors')
            ->where('status', 'approved')
            ->orderBy('due_at')
            ->get();

        $pending = $user->borrowings()
            ->with('book')
            ->where('status', 'requested')
            ->latest()
            ->get();

        $historyCount = $user->borrowings()->whereIn('status', ['returned', 'rejected', 'cancelled'])->count();

        $recommended = Book::query()
            ->with(['authors', 'category'])
            ->available()
            ->whereNotIn('id', $user->borrowings()->select('book_id'))
            ->orderByDesc('view_count')
            ->take(4)
            ->get();

        return view('member.dashboard', [
            'active' => $active,
            'pending' => $pending,
            'historyCount' => $historyCount,
            'unpaidFine' => $user->unpaidFineTotal(),
            'recommended' => $recommended,
            'loanLimit' => Setting::getInt('max_active_loans'),
            'loanDays' => Setting::getInt('loan_duration_days'),
            'finePerDay' => Setting::getInt('fine_per_day'),
        ]);
    }
}
