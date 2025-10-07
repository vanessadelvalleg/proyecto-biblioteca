<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\User;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'loaned_date' => now(),
            'due_date' => now()->addDays(14),
           
        ];
    }

        public function returned()
    {
        return $this->state(fn() => ['returned_at' => now()]);
    }
}

