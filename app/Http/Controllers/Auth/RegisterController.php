<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\MemberRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, MemberRegistrationService $registration): RedirectResponse
    {
        $data = $request->validated();
        $key = 'register|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak pendaftaran dari jaringan ini. Coba lagi nanti.',
            ]);
        }

        RateLimiter::hit($key, 600);

        $user = $registration->register($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('member.dashboard')
            ->with('status', 'Pendaftaran berhasil. Selamat datang di perpustakaan.');
    }
}
