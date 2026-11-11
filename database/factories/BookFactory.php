<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->words(fake()->numberBetween(2, 5), true));
        $copies = fake()->numberBetween(1, 6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'isbn' => null,
            'category_id' => Category::factory(),
            'publisher_id' => Publisher::factory(),
            'publication_year' => fake()->numberBetween(1990, 2025),
            'page_count' => fake()->numberBetween(96, 620),
            'description' => fake()->paragraph(4),
            'total_copies' => $copies,
            'available_copies' => $copies,
            'is_featured' => fake()->boolean(20),
        ];
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes): array => [
            'available_copies' => 0,
        ]);
    }
}
