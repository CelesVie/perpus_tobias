<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'role', 'is_active', 'phone', 'address', 'joined_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
            'joined_at' => 'date',
        ];
    }

    /** @return HasMany<Borrowing, $this> */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /** @return HasMany<Fine, $this> */
    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');
    }

    public function activeLoanCount(): int
    {
        return $this->borrowings()->whereIn('status', Borrowing::ACTIVE_STATUSES)->count();
    }

    public function unpaidFineTotal(): int
    {
        return (int) $this->fines()->where('status', 'unpaid')->sum('amount');
    }
}
