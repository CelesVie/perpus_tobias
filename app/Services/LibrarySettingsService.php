<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class LibrarySettingsService
{
    /** @param array<string, string|int|null> $settings */
    public function update(array $settings): void
    {
        DB::transaction(function () use ($settings): void {
            foreach ($settings as $key => $value) {
                Setting::put($key, (string) $value);
            }

            ActivityLog::record('settings.updated', 'Pengaturan aplikasi diperbarui.');
        });
    }
}
