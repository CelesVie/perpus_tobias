<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BorrowingStatus;
use App\Enums\FineStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'titles' => Book::query()->count(),
            'copies' => (int) Book::query()->sum('total_copies'),
            'members' => User::query()->where('role', UserRole::Member)->count(),
            'active' => Borrowing::query()->where('status', BorrowingStatus::Approved)->count(),
            'pending' => Borrowing::query()->where('status', BorrowingStatus::Requested)->count(),
            'overdue' => Borrowing::query()->overdue()->count(),
            'fines' => (int) Fine::query()->where('status', FineStatus::Unpaid)->sum('amount'),
        ];

        $monthly = collect(range(5, 0))->map(function (int $offset): array {
            $month = now()->subMonths($offset);

            return [
                'label' => $month->translatedFormat('M'),
                'total' => Borrowing::query()
                    ->whereBetween('requested_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                    ->count(),
            ];
        });

        $byCategory = Category::query()
            ->withCount('books')
            ->orderByDesc('books_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'monthly' => $monthly,
            'byCategory' => $byCategory,
            'queue' => Borrowing::query()->with(['user', 'book'])->where('status', BorrowingStatus::Requested)->latest()->take(5)->get(),
            'overdueList' => Borrowing::query()->with(['user', 'book'])->overdue()->orderBy('due_at')->take(5)->get(),
            'activity' => ActivityLog::query()->with('user')->latest('created_at')->take(8)->get(),
        ]);
    }
}
