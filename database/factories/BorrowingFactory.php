<?php

namespace Database\Factories;

use App\Enums\BorrowingStatus;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'status' => BorrowingStatus::Requested->value,
            'requested_at' => now(),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BorrowingStatus::Approved->value,
            'approved_at' => now(),
            'due_at' => now()->addDays(7),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BorrowingStatus::Approved->value,
            'approved_at' => now()->subDays(14),
            'due_at' => now()->subDays(3),
        ]);
    }

    public function returned(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BorrowingStatus::Returned->value,
            'approved_at' => now()->subDays(14),
            'due_at' => now()->subDays(7),
            'returned_at' => now()->subDays(6),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BorrowingStatus::Rejected->value,
            'reject_reason' => 'Eksemplar sedang habis dipinjam anggota lain.',
        ]);
    }
}
