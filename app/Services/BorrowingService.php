<?php

namespace App\Services;

use App\Enums\BorrowingStatus;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingService
{
    /**
     * @throws ValidationException
     */
    public function request(User $member, Book $book, ?string $note = null): Borrowing
    {
        return DB::transaction(function () use ($member, $book, $note): Borrowing {
            $member = User::query()->lockForUpdate()->findOrFail($member->id);
            /** @var Book $locked */
            $locked = Book::query()->lockForUpdate()->findOrFail($book->id);

            $this->ensureMemberEligible($member, $locked);

            $borrowing = Borrowing::query()->create([
                'user_id' => $member->id,
                'book_id' => $locked->id,
                'status' => BorrowingStatus::Requested->value,
                'requested_at' => now(),
                'member_note' => $note,
            ]);

            ActivityLog::record(
                'borrowing.requested',
                "{$member->name} mengajukan peminjaman \"{$locked->title}\".",
                $borrowing
            );

            return $borrowing;
        });
    }

    /**
     * @throws ValidationException
     */
    public function approve(Borrowing $borrowing, User $admin): Borrowing
    {
        return DB::transaction(function () use ($borrowing, $admin): Borrowing {
            $borrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            if ($borrowing->status !== BorrowingStatus::Requested->value) {
                throw ValidationException::withMessages([
                    'borrowing' => 'Hanya permohonan yang menunggu dapat disetujui.',
                ]);
            }

            /** @var Book $book */
            $book = Book::query()->lockForUpdate()->findOrFail($borrowing->book_id);

            if ($book->available_copies < 1) {
                throw ValidationException::withMessages([
                    'stock' => 'Eksemplar buku ini sedang tidak tersedia. Tolak permohonan atau tambah eksemplar.',
                ]);
            }

            $borrowing->forceFill([
                'status' => BorrowingStatus::Approved->value,
                'approved_at' => now(),
                'due_at' => now()->addDays(Setting::getInt('loan_duration_days')),
                'processed_by' => $admin->id,
            ])->save();

            $book->decrement('available_copies');

            ActivityLog::record(
                'borrowing.approved',
                "Peminjaman {$borrowing->code} disetujui oleh {$admin->name}.",
                $borrowing
            );

            return $borrowing;
        });
    }

    public function reject(Borrowing $borrowing, User $admin, string $reason): Borrowing
    {
        return DB::transaction(function () use ($borrowing, $admin, $reason): Borrowing {
            $borrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            if ($borrowing->status !== BorrowingStatus::Requested->value) {
                throw ValidationException::withMessages([
                    'borrowing' => 'Hanya permohonan yang menunggu dapat ditolak.',
                ]);
            }

            $borrowing->forceFill([
                'status' => BorrowingStatus::Rejected->value,
                'reject_reason' => $reason,
                'processed_by' => $admin->id,
            ])->save();

            ActivityLog::record(
                'borrowing.rejected',
                "Peminjaman {$borrowing->code} ditolak oleh {$admin->name}.",
                $borrowing
            );

            return $borrowing;
        });
    }

    public function cancel(Borrowing $borrowing): Borrowing
    {
        return DB::transaction(function () use ($borrowing): Borrowing {
            $borrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            if ($borrowing->status !== BorrowingStatus::Requested->value) {
                throw ValidationException::withMessages([
                    'borrowing' => 'Hanya permohonan yang menunggu dapat dibatalkan.',
                ]);
            }

            $borrowing->forceFill(['status' => BorrowingStatus::Cancelled->value])->save();

            ActivityLog::record('borrowing.cancelled', "Peminjaman {$borrowing->code} dibatalkan anggota.", $borrowing);

            return $borrowing;
        });
    }

    /**
     * Process a return: mark the loan finished and restore the copy.
     */
    public function returnBook(Borrowing $borrowing, User $admin): Borrowing
    {
        return DB::transaction(function () use ($borrowing, $admin): Borrowing {
            $borrowing = Borrowing::query()->lockForUpdate()->findOrFail($borrowing->id);

            if ($borrowing->status !== BorrowingStatus::Approved->value) {
                throw ValidationException::withMessages([
                    'borrowing' => 'Hanya pinjaman aktif yang dapat dikembalikan.',
                ]);
            }

            /** @var Book $book */
            $book = Book::query()->lockForUpdate()->findOrFail($borrowing->book_id);

            $borrowing->returned_at = now();
            $borrowing->status = BorrowingStatus::Returned->value;
            $borrowing->save();

            $book->increment('available_copies');

            ActivityLog::record(
                'borrowing.returned',
                "Pengembalian {$borrowing->code} diproses oleh {$admin->name}.",
                $borrowing
            );

            return $borrowing;
        });
    }

    /**
     * @throws ValidationException
     */
    private function ensureMemberEligible(User $member, Book $book): void
    {
        if (! $member->is_active) {
            throw ValidationException::withMessages(['member' => 'Akun Anda belum aktif.']);
        }

        if (! $book->isAvailable()) {
            throw ValidationException::withMessages(['book' => 'Semua eksemplar buku ini sedang dipinjam.']);
        }

        if ($member->activeLoanCount() >= Setting::getInt('max_active_loans')) {
            throw ValidationException::withMessages([
                'book' => 'Batas peminjaman aktif ('.Setting::getInt('max_active_loans').') sudah tercapai.',
            ]);
        }

        $duplicate = $member->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', Borrowing::ACTIVE_STATUSES)
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'book' => 'Anda masih memiliki permohonan atau pinjaman aktif untuk buku ini.',
            ]);
        }
    }
}
