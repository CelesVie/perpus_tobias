<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MemberAccountService
{
    /**
     * Daftarkan anggota baru dari panel admin.
     *
     * @param  array{name: string, email: string, phone?: ?string, address?: ?string, password: string}  $data
     */
    public function createMember(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $member = new User;
            $member->forceFill([
                'name' => trim($data['name']),
                'email' => mb_strtolower(trim($data['email'])),
                'phone' => filled($data['phone'] ?? null) ? trim($data['phone']) : null,
                'address' => filled($data['address'] ?? null) ? trim($data['address']) : null,
                'password' => $data['password'],
                'role' => UserRole::Member,
                'is_active' => true,
                'email_verified_at' => now(),
                'joined_at' => now()->toDateString(),
            ])->save();

            ActivityLog::record('member.created', "Akun anggota {$member->name} ditambahkan pustakawan.", $member);

            return $member;
        });
    }

    /**
     * Perbarui data anggota; kata sandi hanya diganti bila diisi.
     *
     * @param  array{name: string, email: string, phone?: ?string, address?: ?string, password?: ?string}  $data
     */
    public function updateMember(User $member, array $data): User
    {
        return DB::transaction(function () use ($member, $data): User {
            $member = User::query()->lockForUpdate()->findOrFail($member->id);

            if ($member->role !== UserRole::Member) {
                throw ValidationException::withMessages(['member' => 'Akun ini bukan akun anggota.']);
            }

            $member->forceFill([
                'name' => trim($data['name']),
                'email' => mb_strtolower(trim($data['email'])),
                'phone' => filled($data['phone'] ?? null) ? trim($data['phone']) : null,
                'address' => filled($data['address'] ?? null) ? trim($data['address']) : null,
            ]);

            if (filled($data['password'] ?? null)) {
                $member->password = $data['password'];
            }

            $member->save();

            ActivityLog::record('member.updated', "Data akun anggota {$member->name} diperbarui pustakawan.", $member);

            return $member;
        });
    }

    public function toggle(User $member): User
    {
        return DB::transaction(function () use ($member): User {
            $member = User::query()->lockForUpdate()->findOrFail($member->id);

            if ($member->role !== UserRole::Member) {
                throw ValidationException::withMessages(['member' => 'Akun ini bukan akun anggota.']);
            }

            $member->update(['is_active' => ! $member->is_active]);
            ActivityLog::record(
                'member.toggled',
                "Akun {$member->name} ".($member->is_active ? 'diaktifkan' : 'dinonaktifkan').'.',
                $member
            );

            return $member;
        });
    }

    public function delete(User $member): void
    {
        DB::transaction(function () use ($member): void {
            $member = User::query()->lockForUpdate()->findOrFail($member->id);

            if ($member->role !== UserRole::Member) {
                throw ValidationException::withMessages(['member' => 'Akun ini bukan akun anggota.']);
            }

            if ($member->borrowings()->exists()) {
                throw ValidationException::withMessages([
                    'member' => 'Anggota tidak dapat dihapus karena memiliki riwayat peminjaman. Gunakan opsi nonaktifkan akun.',
                ]);
            }

            $name = $member->name;
            $member->forceDelete();

            ActivityLog::record('member.deleted', "Akun anggota {$name} dihapus permanen.");
        });
    }
}
