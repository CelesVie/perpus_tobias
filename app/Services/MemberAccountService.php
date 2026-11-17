<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MemberAccountService
{
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
