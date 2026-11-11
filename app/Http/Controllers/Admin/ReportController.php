<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportPeriodRequest;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(ReportPeriodRequest $request): View
    {
        $period = $request->validated('periode') ?: 'bulan-ini';
        [$from, $to] = $this->range($period);

        return view('admin.reports.index', [
            'period' => $period,
            'from' => $from,
            'to' => $to,
            'summary' => [
                'requests' => Borrowing::query()->whereBetween('requested_at', [$from, $to])->count(),
                'returns' => Borrowing::query()->whereBetween('returned_at', [$from, $to])->count(),
                'fines' => (int) Fine::query()->whereBetween('created_at', [$from, $to])->sum('amount'),
                'newMembers' => User::query()->where('role', 'member')->whereBetween('created_at', [$from, $to])->count(),
            ],
            'topBooks' => Book::query()
                ->withCount(['borrowings' => fn ($q) => $q->whereBetween('requested_at', [$from, $to])])
                ->with('authors')
                ->orderByDesc('borrowings_count')
                ->take(8)
                ->get(),
            'byCategory' => Category::query()
                ->withCount(['books' => fn ($q) => $q->whereHas(
                    'borrowings', fn ($b) => $b->whereBetween('requested_at', [$from, $to])
                )])
                ->orderByDesc('books_count')
                ->get(),
        ]);
    }

    public function export(ReportPeriodRequest $request): StreamedResponse
    {
        [$from, $to] = $this->range($request->validated('periode') ?: 'bulan-ini');

        return response()->streamDownload(function () use ($from, $to): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Kode', 'Anggota', 'Buku', 'Status', 'Diajukan', 'Jatuh tempo', 'Dikembalikan']);

            Borrowing::query()
                ->with(['user', 'book'])
                ->whereBetween('requested_at', [$from, $to])
                ->orderBy('requested_at')
                ->chunk(500, function ($rows) use ($out): void {
                    foreach ($rows as $row) {
                        fputcsv($out, [
                            $row->code,
                            $row->user?->name,
                            $row->book?->title,
                            $row->status,
                            $row->requested_at?->toDateTimeString(),
                            $row->due_at?->toDateTimeString(),
                            $row->returned_at?->toDateTimeString(),
                        ]);
                    }
                });

            fclose($out);
        }, 'laporan-peminjaman-'.now()->format('Ymd').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function range(string $period): array
    {
        return match ($period) {
            'minggu-ini' => [now()->startOfWeek(), now()->endOfWeek()],
            'bulan-lalu' => [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()],
            'tahun-ini' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }
}
