<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->company(),
            'isbn' => $this->faker->isbn13(),
            'category' => $this->faker->randomElement(array_keys(book_categories())),
            'cover_image' => $this->randomImage(),
            'state' => $this->faker->randomElement(Book::getStatesFor('state')),
            'published_at' => $this->faker->date(),
            'page_count' => $this->faker->randomNumber(),
        ];
    }

    private function randomImage(): string
    {
        return 'https://placehold.co/'
            . fake()->numberBetween(300, 800) . 'x'
            . fake()->numberBetween(200, 600) . '/'
            . fake()->safeColorName() . '/'
            . fake()->safeColorName() .
            '.png?text=' . fake()->word();
    }
}
