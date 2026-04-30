<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->numerify('##########'), 
            'status' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contractual']),
            'user_id' => $this->faker->unique()->numberBetween(1, 1000),
            'department' => $this->faker->randomElement(['English/Language Arts', 'Mathematics', 'Science', 'Social Studies', 'MAPEH', 'Technology & Livelihood Education', 'Foreign Languages', 'Guidance Department']),
            'specialization' => $this->faker->randomElement(['asd', 'zxc']),
            'is_active' => $this->faker->boolean(90), 
        ];
    }
}
