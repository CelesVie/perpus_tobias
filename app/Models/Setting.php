<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public const DEFAULTS = [
        'library_name' => 'Pustaka Nusantara',
        'library_tagline' => 'Ilmu yang terbuka untuk semua',
        'library_address' => 'Jl. Diponegoro No. 42, Bandung',
        'library_phone' => '(022) 8842 1901',
        'library_email' => 'halo@pustaka.test',
        'loan_duration_days' => '7',
        'max_active_loans' => '3',
        'fine_per_day' => '1000',
        'max_fine_days' => '30',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = Cache::rememberForever("setting.{$key}", fn (): ?string => static::query()->find($key)?->value);

        return $value ?? $default ?? self::DEFAULTS[$key] ?? null;
    }

    public static function getInt(string $key): int
    {
        return (int) self::get($key);
    }

    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting.{$key}");
    }
}
