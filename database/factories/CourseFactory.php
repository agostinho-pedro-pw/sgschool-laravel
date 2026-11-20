<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the course data used in tests and seeders.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'courseCode' => fake()->unique()->bothify('CRS-###'),
            'courseName' => fake()->words(3, true),
            'department' => fake()->word().' Department',
            'courseDescription' => fake()->sentence(),
        ];
    }
}
