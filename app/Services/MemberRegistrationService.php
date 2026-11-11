<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberRegistrationService
{
    /** @param array{name: string, email: string, phone?: ?string, address?: ?string, password: string} $data */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $user = User::query()->create([
                'name' => trim($data['name']),
                'email' => mb_strtolower(trim($data['email'])),
                'phone' => filled($data['phone'] ?? null) ? trim($data['phone']) : null,
                'address' => filled($data['address'] ?? null) ? trim($data['address']) : null,
                'password' => Hash::make($data['password']),
                'role' => UserRole::Member,
                'is_active' => true,
                'joined_at' => now()->toDateString(),
            ]);

            event(new Registered($user));
            ActivityLog::record('auth.registered', 'Mendaftar sebagai anggota baru.', $user);

            return $user;
        });
    }
}
