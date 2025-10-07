<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('subscriptions')->insert([
            [
                'user_id' => 1,
                'plan_name' => 'premium',
                'status' => 'active',
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonth(),
                'stripe_subscription_id' => null,
            ],
            [
                'user_id' => 2,
                'plan_name' => 'basic',
                'status' => 'past_due',
                'starts_at' => $now->copy()->subMonth(),
                'ends_at' => $now->copy()->addDays(5),
                'stripe_subscription_id' => null,
            ],
            [
                'user_id' => 3,
                'plan_name' => 'premium',
                'status' => 'cancelled',
                'starts_at' => $now->copy()->subMonths(2),
                'ends_at' => $now->copy()->subDays(10),
                'stripe_subscription_id' => null,
            ],
        ]);
    }
}
