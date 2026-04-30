<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lrn' => $this->faker->numerify('##########'), 
            'user_id' => $this->faker->unique()->numberBetween(1, 1000),
            'grade_level' => $this->faker->randomElement(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']),
            'section' => $this->faker->randomElement(['A', 'B', 'C']),
            'gwa' => $this->faker->randomFloat(2, 75, 99),
            'is_active' => $this->faker->boolean(90), 
        ];
    }
}
