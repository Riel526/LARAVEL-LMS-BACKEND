<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Major', 'Minor', 'Elective', 'General Education', 'Professional'];
        
        return [
            'subject_code' => $this->faker->unique()->bothify('??-###'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'units' => $this->faker->numberBetween(1, 5),
            'category' => $this->faker->randomElement($categories),
            'image_path' => null,
            'is_active' => true,
        ];
    }
}
