<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User php artisan tinker and run this code instead of running the whole seeder
        // App\Models\Student::factory(50)->create();
        // App\Models\Users::factory(50)->create();


        // seeder for Teacher/Student faker

    //     \App\Models\User::factory(10)->create()->each(function ($user) {
    //     \App\Models\Teacher::factory()->create([
    //         'user_id' => $user->id
    //     ]);

    //     \App\Models\User::factory(10)->create()->each(function ($user) {
    //     \App\Models\Student::factory()->create([
    //         'user_id' => $user->id
    //     ]);
    // });
    }
}
