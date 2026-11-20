<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Adiciona cursos de exemplo.
        Course::factory()->create([
            'courseCode' => 'CS101',
            'courseName' => 'Introduction to Computer Science',
            'department' => 'Computer Science',
        ]);

        Course::factory()->create([
            'courseCode' => 'BUS201',
            'courseName' => 'Business Informatics',
            'department' => 'Business',
        ]);
    }
}
