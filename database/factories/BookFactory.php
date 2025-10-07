<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->unique()->isbn13(),
            'published_year' => $this->faker->year(),
            'available_copies' => $this->faker->numberBetween(1, 10),
            'total_copies' => $this->faker->numberBetween(1, 10),
        ];
    }
}

