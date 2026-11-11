<?php

namespace App\Policies;

use App\Enums\BorrowingStatus;
use App\Models\Borrowing;
use App\Models\User;

class BorrowingPolicy
{
    public function view(User $user, Borrowing $borrowing): bool
    {
        return $user->isAdmin() || $borrowing->user_id === $user->id;
    }

    public function cancel(User $user, Borrowing $borrowing): bool
    {
        return $borrowing->user_id === $user->id
            && $borrowing->status === BorrowingStatus::Requested->value;
    }

    public function approve(User $user, Borrowing $borrowing): bool
    {
        return $user->isAdmin() && $borrowing->status === BorrowingStatus::Requested->value;
    }

    public function reject(User $user, Borrowing $borrowing): bool
    {
        return $user->isAdmin() && $borrowing->status === BorrowingStatus::Requested->value;
    }

    public function returnBook(User $user, Borrowing $borrowing): bool
    {
        return $user->isAdmin() && $borrowing->status === BorrowingStatus::Approved->value;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }
}
