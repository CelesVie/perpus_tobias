<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_if($user === null, 401);

        if (! $user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Hubungi pustakawan.',
            ]);
        }

        $allowed = array_map(fn (string $role): UserRole => UserRole::from($role), $roles);

        abort_unless(in_array($user->role, $allowed, true), 403, 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
