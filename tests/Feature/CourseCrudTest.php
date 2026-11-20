<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_can_be_created_viewed_updated_and_deleted(): void
    {
        $courseData = [
            'courseCode' => 'CS101',
            'courseName' => 'Introduction to Computer Science',
            'department' => 'Computer Science',
            'courseDescription' => 'An introduction to computer science.',
        ];

        $this->get(route('courses.create'))
            ->assertOk()
            ->assertSee('Course Code')
            ->assertSee('Course Name')
            ->assertSee('Department')
            ->assertSee('Course Description')
            ->assertSee('Create Course');

        $this->post(route('courses.store'), $courseData)
            ->assertRedirect(route('courses.index'));

        $course = Course::firstOrFail();

        $this->assertDatabaseHas('courses', $courseData);

        $this->get(route('courses.index'))
            ->assertOk()
            ->assertSee('CS101')
            ->assertSee('Introduction to Computer Science')
            ->assertSee('Computer Science')
            ->assertSee('Search courses...')
            ->assertSee('View')
            ->assertSee('Edit')
            ->assertSee('Delete');

        $this->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('An introduction to computer science.');

        $this->get(route('courses.edit', $course))
            ->assertOk()
            ->assertSee('Update Course');

        $updatedData = array_replace($courseData, [
            'courseName' => 'Computer Science Basics',
        ]);

        $this->put(route('courses.update', $course), $updatedData)
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'courseName' => 'Computer Science Basics',
        ]);

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
