<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\Course;
use App\Models\Room;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // Lista todas as turmas por ordem alfabética.
    public function index()
    {
        $schoolClasses = SchoolClass::with(['course', 'room', 'classLevel'])
            ->orderBy('className')
            ->get();

        return view(
            'admin.school-classes.all-school-classes.index',
            compact('schoolClasses')
        );
    }

    // Mostra o formulário para criar uma turma.
    public function create()
    {
        return view('admin.school-classes.add-school-class.index', [
            'courses' => Course::orderBy('courseName')->get(),
            'rooms' => Room::orderBy('designacao')->get(),
            'classLevels' => ClassLevel::orderBy('classLevelName')->get(),
        ]);
    }

    // Guarda uma nova turma.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'className' => ['required', 'string', 'max:20'],
            'course_id' => ['required', 'exists:courses,id'],
            'period' => ['required', 'string', 'max:10'],
            'room_id' => ['nullable', 'exists:rooms,id_sala'],
            'class_level_id' => ['nullable', 'exists:class_levels,classLevelId'],
        ]);

        SchoolClass::create($validated);

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma criada com sucesso.');
    }

    // Mostra os detalhes de uma turma.
    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load(['course', 'room', 'classLevel']);

        return view(
            'admin.school-classes.school-class-info.index',
            compact('schoolClass')
        );
    }

    // Mostra o formulário para editar uma turma.
    public function edit(SchoolClass $schoolClass)
    {
        return view('admin.school-classes.edit-school-class.index', [
            'schoolClass' => $schoolClass,
            'courses' => Course::orderBy('courseName')->get(),
            'rooms' => Room::orderBy('designacao')->get(),
            'classLevels' => ClassLevel::orderBy('classLevelName')->get(),
        ]);
    }

    // Atualiza uma turma.
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'className' => ['required', 'string', 'max:20'],
            'course_id' => ['required', 'exists:courses,id'],
            'period' => ['required', 'string', 'max:10'],
            'room_id' => ['nullable', 'exists:rooms,id_sala'],
            'class_level_id' => ['nullable', 'exists:class_levels,classLevelId'],
        ]);

        $schoolClass->update($validated);

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma atualizada com sucesso.');
    }

    // Elimina uma turma.
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma eliminada com sucesso.');
    }
}
