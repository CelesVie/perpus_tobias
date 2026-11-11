<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\BorrowingIndexRequest;
use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Book;
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
        $status = $request->validated('status') ?: null;

        return view('member.borrowings.index', [
            'borrowings' => $request->user()->borrowings()
                ->with('book.authors')
                ->when($status, fn ($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10),
            'status' => $status,
        ]);
    }

    public function show(Borrowing $borrowing): View
    {
        $this->authorize('view', $borrowing);

        return view('member.borrowings.show', [
            'borrowing' => $borrowing->load(['book.authors', 'book.category', 'fine']),
        ]);
    }

    public function store(StoreBorrowingRequest $request, Book $book): RedirectResponse
    {
        try {
            $borrowing = $this->borrowings->request($request->user(), $book, trim($request->validated('member_note') ?? '') ?: null);
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->validator)->withInput();
        }

        return redirect()->route('member.borrowings.show', $borrowing)
            ->with('status', 'Permohonan peminjaman dikirim. Tunggu persetujuan pustakawan.');
    }

    public function cancel(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('cancel', $borrowing);

        try {
            $this->borrowings->cancel($borrowing);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return back()->with('status', 'Permohonan peminjaman dibatalkan.');
    }
}
