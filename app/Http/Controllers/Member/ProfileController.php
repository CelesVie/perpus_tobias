<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\MemberProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('member.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request, MemberProfileService $profiles): RedirectResponse
    {
        $profiles->update($request->user(), $request->validated());

        return back()->with('status', 'Profil diperbarui.');
    }
}
