<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = Carbon::now();

        DB::table('loans')->insert([
            [
                'user_id' => 1,
                'book_id' => 1,
                'loaned_at' => $now,
                'due_date' => $now->copy()->addDays(14),
                'returned_at' => null,
            ],
            [
                'user_id' => 2,
                'book_id' => 2,
                'loaned_at' => $now->copy()->subDays(5),
                'due_date' => $now->copy()->addDays(9),
                'returned_at' => null,
            ],
            [
                'user_id' => 3,
                'book_id' => 3,
                'loaned_at' => $now->copy()->subDays(10),
                'due_date' => $now->copy()->subDays(-4),
                'returned_at' => null,
            ],
        ]);
    }
}
