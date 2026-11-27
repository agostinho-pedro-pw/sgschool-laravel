<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Room;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\ClassLevel;

class SchoolClassController extends Controller
{
    // Lista todas as turmas por ordem alfabética
    public function index()
    {
        $schoolClasses = SchoolClass::with(['course', 'room'])
            ->orderBy('nomeTurma')
            ->get();

        return view('admin.school-classes.all-school-classes.index', compact('schoolClasses'));
    }

    // Mostra o formulário para criar uma Turma
    public function create()
    {
        return view('admin.school-classes.add-school-class.index', [
            'courses' => Course::orderBy('courseName')->get(),
            'rooms' => Room::orderBy('designacao')->get(),
            'classLevels' => ClassLevel::orderBy('nome_classe')->get(),
        ]);
    }

    // Guarda uma nova Turma
    public function store(Request $request)
    {
        SchoolClass::create($request->only([
            'nomeTurma',
            'classe',
            'course_id',
            'periodo',
            'room_id',
            'class_level_id', // FK com a tabela rooms
        ]));

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma criada com sucesso.');
    }

    // Mostra os detalhes de uma Turma
    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load(['course', 'room', 'classLevel']);

        return view('admin.school-classes.school-class-info.index', compact('schoolClass'));
    }

    // Mostra o formulário para editar uma Turma
    public function edit(SchoolClass $schoolClass)
    {
        return view('admin.school-classes.edit-school-class.index', [
            'schoolClass' => $schoolClass,
            'courses'     => Course::orderBy('courseName')->get(),
            'rooms'       => Room::orderBy('designacao')->get(),
            'classLevels' => ClassLevel::orderBy('nome_classe')->get(),
        ]);
    }

    // Atualiza uma Turma
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $schoolClass->update($request->only([
            'nomeTurma',
            'classe',
            'course_id',
            'periodo',
            'room_id', // FK com a tabela rooms
            'class_level_id', // FK com a tabela rooms
        ]));

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma atualizada com sucesso.');
    }

    // Elimina uma Turma
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Turma eliminada com sucesso.');
    }
}
