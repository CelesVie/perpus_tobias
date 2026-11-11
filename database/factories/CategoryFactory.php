<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Fiksi', 'Sastra', 'Sejarah', 'Sains', 'Teknologi', 'Ekonomi',
            'Pendidikan', 'Agama', 'Bahasa', 'Buku Anak', 'Referensi', 'Seni',
        ]).' '.fake()->unique()->randomNumber(2);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(12),
        ];
    }
}
