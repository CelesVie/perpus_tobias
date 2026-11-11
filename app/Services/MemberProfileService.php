<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;

class MemberProfileService
{
    /** @param array{name: string, phone?: ?string, address?: ?string, password?: ?string|null} $data */
    public function update(User $user, array $data): User
    {
        $profile = array_intersect_key($data, array_flip(['name', 'phone', 'address']));

        if (filled($data['password'] ?? null)) {
            $profile['password'] = $data['password'];
        }

        $user->update($profile);
        ActivityLog::record('profile.updated', 'Memperbarui data profil.', $user);

        return $user;
    }
}
