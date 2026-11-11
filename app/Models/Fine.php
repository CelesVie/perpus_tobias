<?php

namespace App\Models;

use App\Enums\FineStatus;
use Database\Factories\FineFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['borrowing_id', 'user_id', 'days_late', 'amount', 'status', 'paid_at'])]
class Fine extends Model
{
    /** @use HasFactory<FineFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => FineStatus::class,
            'paid_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<Borrowing, $this> */
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
