<?php

namespace App\Models;

use Database\Factories\BorrowingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[Fillable([
    'code', 'user_id', 'book_id', 'status', 'requested_at', 'approved_at',
    'due_at', 'returned_at', 'processed_by', 'member_note', 'reject_reason',
])]
class Borrowing extends Model
{
    /** @use HasFactory<BorrowingFactory> */
    use HasFactory;

    public const ACTIVE_STATUSES = ['requested', 'approved'];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'due_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Book, $this> */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /** @return BelongsTo<User, $this> */
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /** @return HasOne<Fine, $this> */
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    public function isOverdue(): bool
    {
        return $this->due_at !== null
            && $this->returned_at === null
            && $this->due_at->isPast();
    }

    public function daysLate(): int
    {
        if ($this->due_at === null) {
            return 0;
        }

        $end = $this->returned_at ?? now();

        return max(0, (int) $this->due_at->startOfDay()->diffInDays($end->startOfDay(), false));
    }

    public function statusLabel(): string
    {
        return \App\Enums\BorrowingStatus::from($this->status)->label();
    }

    #[Scope]
    protected function overdue(Builder $query): void
    {
        $query->where('status', 'approved')->whereNull('returned_at')->where('due_at', '<', now());
    }

    protected static function booted(): void
    {
        static::creating(function (Borrowing $borrowing): void {
            $borrowing->code ??= 'PJM-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        });
    }
}
