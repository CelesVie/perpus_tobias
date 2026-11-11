<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BorrowingIndexRequest;
use App\Http\Requests\Admin\RejectBorrowingRequest;
use App\Models\Borrowing;
use App\Services\BorrowingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function __construct(private readonly BorrowingService $borrowings) {}

    public function index(BorrowingIndexRequest $request): View
    {
        $filters = $request->validated();
        $status = $filters['status'] ?? 'requested';
        $term = trim($filters['q'] ?? '');

        $query = Borrowing::query()
            ->with(['user', 'book'])
            ->when(! in_array($status, ['semua', 'terlambat'], true), fn ($q) => $q->where('status', $status))
            ->when($status === 'terlambat', fn ($q) => $q->overdue())
            ->when($term, fn ($q) => $q->where(fn ($inner) => $inner
                ->where('code', 'like', "%{$term}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%"))
                ->orWhereHas('book', fn ($b) => $b->where('title', 'like', "%{$term}%"))));

        return view('admin.borrowings.index', [
            'borrowings' => $query->latest('requested_at')->paginate(12)->withQueryString(),
            'status' => $status,
            'term' => $term,
            'counts' => [
                'requested' => Borrowing::query()->where('status', 'requested')->count(),
                'approved' => Borrowing::query()->where('status', 'approved')->count(),
                'terlambat' => Borrowing::query()->overdue()->count(),
            ],
        ]);
    }

    public function show(Borrowing $borrowing): View
    {
        return view('admin.borrowings.show', [
            'borrowing' => $borrowing->load(['user', 'book.authors', 'book.category', 'handler', 'fine']),
        ]);
    }

    public function approve(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('approve', $borrowing);

        try {
            $this->borrowings->approve($borrowing, request()->user());
        } catch (ValidationException $e) {
            return back()->with('error', $e->validator->errors()->first());
        }

        return back()->with('status', 'Peminjaman disetujui. Jatuh tempo tercatat.');
    }

    public function reject(RejectBorrowingRequest $request, Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('reject', $borrowing);

        $data = $request->validated();

        $this->borrowings->reject($borrowing, $request->user(), $data['reject_reason']);

        return back()->with('status', 'Permohonan ditolak.');
    }

    public function returnBook(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('returnBook', $borrowing);

        try {
            [$returned, $fine] = $this->borrowings->returnBook($borrowing, request()->user());
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return redirect()->route('admin.borrowings.show', $returned)
            ->with('status', $fine
                ? "Pengembalian dicatat. Denda Rp{$fine->amount} diterbitkan."
                : 'Pengembalian dicatat tepat waktu.');
    }
}
