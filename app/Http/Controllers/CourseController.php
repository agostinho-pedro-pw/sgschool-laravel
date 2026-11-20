<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Lista os cursos
    public function index()
    {
        $courses = Course::orderBy('courseCode')->get();

        return view('admin.courses.all-courses.index', compact('courses'));
    }

    // Mostra o formulário para criar um curso
    public function create()
    {
        return view('admin.courses.add-course.index');
    }

    // Guarda um novo curso
    public function store(Request $request)
    {
        Course::create($request->only([
            'courseCode',
            'courseName',
            'department',
            'courseDescription',
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Curso criado com sucesso.');
    }

    // Mostra os dados de um curso
    public function show(Course $course)
    {
        return view('admin.courses.course-info.index', compact('course'));
    }

    // Mostra o formulário para editar um curso
    public function edit(Course $course)
    {
        return view('admin.courses.edit-course.index', compact('course'));
    }

    // Atualiza os dados do curso
    public function update(Request $request, Course $course)
    {
        $course->update($request->only([
            'courseCode',
            'courseName',
            'department',
            'courseDescription',
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Curso atualizado com sucesso.');
    }

    // Elimina um curso
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Curso eliminado com sucesso.');
    }
}
