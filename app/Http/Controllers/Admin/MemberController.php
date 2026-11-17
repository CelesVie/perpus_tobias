<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberIndexRequest;
use App\Models\User;
use App\Services\MemberAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(MemberIndexRequest $request): View
    {
        $term = trim($request->validated('q') ?? '');

        return view('admin.members.index', [
            'members' => User::query()
                ->where('role', 'member')
                ->when($term, fn ($q) => $q->where(fn ($inner) => $inner
                    ->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")))
                ->withCount(['borrowings as active_loans_count' => fn ($q) => $q->whereIn('status', ['requested', 'approved'])])
                ->latest('created_at')
                ->orderByDesc('id')
                ->paginate(12)
                ->withQueryString(),
            'term' => $term,
        ]);
    }

    public function show(User $member): View
    {
        abort_unless($member->role->value === 'member', 404);

        return view('admin.members.show', [
            'member' => $member,
            'borrowings' => $member->borrowings()->with('book')->latest('created_at')->orderByDesc('id')->paginate(10),
        ]);
    }

    public function toggle(User $member, MemberAccountService $accounts): RedirectResponse
    {
        abort_unless($member->role === UserRole::Member, 404);

        $accounts->toggle($member);

        return back()->with('status', 'Status akun diperbarui.');
    }

    public function destroy(User $member, MemberAccountService $accounts): RedirectResponse
    {
        abort_unless($member->role === UserRole::Member, 404);

        try {
            $accounts->delete($member);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return redirect()->route('admin.members.index')->with('status', 'Akun anggota dihapus permanen.');
    }
}
