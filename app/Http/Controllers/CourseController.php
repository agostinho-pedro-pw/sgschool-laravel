<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    // Mostra todos os cursos
    public function index(): View
    {
        $courses = Course::orderBy('courseCode')->get();

        return view('admin.courses.all-courses.index', compact('courses'));
    }

    // Mostra o formulário para criar um curso
    public function create(): View
    {
        return view('admin.courses.add-course.index');
    }

    // Guarda o novo curso
    public function store(Request $request): RedirectResponse
    {
        $courseData = $request->validate([
            'courseCode' => ['required', 'string', 'max:50'],
            'courseName' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'courseDescription' => ['nullable', 'string'],
        ]);

        Course::create($courseData);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    // Mostra os dados de um curso
    public function show(Course $course): View
    {
        return view('admin.courses.course-info.index', compact('course'));
    }

    // Mostra o formulário para editar um curso
    public function edit(Course $course): View
    {
        return view('admin.courses.edit-course.index', compact('course'));
    }

    // Atualiza os dados do curso
    public function update(Request $request, Course $course): RedirectResponse
    {
        $courseData = $request->validate([
            'courseCode' => ['required', 'string', 'max:50'],
            'courseName' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'courseDescription' => ['nullable', 'string'],
        ]);

        $course->update($courseData);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    // Elimina o curso
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
