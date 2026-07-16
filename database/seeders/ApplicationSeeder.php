<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        \App\Models\Application::insert([
            ['user_id' => $user->id, 'company' => 'Grab', 'role' => 'Software Engineer', 'status' => 'interview', 'applied_at' => '2026-07-01', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $user->id, 'company' => 'Shopee', 'role' => 'Backend Developer', 'status' => 'applied', 'applied_at' => '2026-07-05', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $user->id, 'company' => 'AirAsia', 'role' => 'Full Stack Developer', 'status' => 'offer', 'applied_at' => '2026-06-20', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $user->id, 'company' => 'Petronas Digital', 'role' => 'Software Developer', 'status' => 'rejected', 'applied_at' => '2026-06-15', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
