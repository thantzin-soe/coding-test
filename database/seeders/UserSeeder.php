<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('thantzinsoe')],
            ['name' => 'Manager', 'email' => 'manager@gmail.com', 'password' => bcrypt('thantzinsoe')],
            ['name' => 'TZS', 'email' => 'tzs@gmail.com', 'password' => bcrypt('thantzinsoe')]
        ];

        foreach ($users as $user) {
            User::create($user);
        }


        User::factory()->count(20)->create();
    }
}
