<?php

namespace Database\Factories;

use App\Enums\FineStatus;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fine>
 */
class FineFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $daysLate = fake()->numberBetween(1, 10);

        return [
            'borrowing_id' => Borrowing::factory()->returned(),
            'user_id' => fn (array $attributes): int => (int) Borrowing::find($attributes['borrowing_id'])->user_id,
            'days_late' => $daysLate,
            'amount' => $daysLate * 1000,
            'status' => FineStatus::Unpaid,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => FineStatus::Paid,
            'paid_at' => now(),
        ]);
    }
}
