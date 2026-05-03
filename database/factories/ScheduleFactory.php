<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        //     INSERT INTO schedules (
        //     subject_id, 
        //     teacher_id, 
        //     section, 
        //     year_level, 
        //     day, 
        //     start_time, 
        //     end_time, 
        //     room, 
        //     created_at, 
        //     updated_at
        // )
        // VALUES 
        // (1, 1, 'A', 7, 'Monday', '08:00:00', '10:00:00', 'Room 101', NOW(), NOW()),
        // (1, 1, 'A', 7, 'Wednesday', '13:00:00', '15:00:00', 'Lab 1', NOW(), NOW()),
        // (1, 1, 'A', 7, 'Tuesday', '09:00:00', '11:00:00', 'Room 202', NOW(), NOW());

            
        ];
    }
}
