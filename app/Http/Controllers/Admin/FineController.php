<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FineIndexRequest;
use App\Models\Fine;
use App\Services\BorrowingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FineController extends Controller
{
    public function __construct(private readonly BorrowingService $borrowings) {}

    public function index(FineIndexRequest $request): View
    {
        $status = $request->validated('status') ?: 'unpaid';

        return view('admin.fines.index', [
            'fines' => Fine::query()
                ->with(['user', 'borrowing.book'])
                ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'status' => $status,
            'totalUnpaid' => (int) Fine::query()->where('status', 'unpaid')->sum('amount'),
        ]);
    }

    public function pay(Fine $fine): RedirectResponse
    {
        try {
            $this->borrowings->payFine($fine, request()->user());
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return back()->with('status', 'Denda ditandai lunas.');
    }
}
