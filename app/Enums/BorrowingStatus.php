<?php

namespace App\Enums;

enum BorrowingStatus: string
{
    case Requested = 'requested';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Returned = 'returned';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Requested => 'Menunggu persetujuan',
            self::Approved => 'Sedang dipinjam',
            self::Rejected => 'Ditolak',
            self::Returned => 'Dikembalikan',
            self::Cancelled => 'Dibatalkan',
        };
    }

    /** @return array<int, string> */
    public static function activeValues(): array
    {
        return [self::Requested->value, self::Approved->value];
    }
}
