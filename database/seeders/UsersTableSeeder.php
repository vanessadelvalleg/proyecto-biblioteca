<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Vanessa del Valle',
                'email' => 'vanessa@ejemplo.com',
                'password' => Hash::make('Eu27#n5'),
            ],
            [
                'name' => 'Denisse Marcell',
                'email' => 'denissenars@ejemplo.com',
                'password' => Hash::make('92|Y7z9'),
            ],
            [
                'name' => 'Miranda Jimenez',
                'email' => 'mirandajimenez1@ejemplo.com',
                'password' => Hash::make('2BZ42&r'),
            ],
        ]);
    }
}
