<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use Illuminate\Http\Request;

class ClassLevelController extends Controller
{
    // Lista os níveis de classe por ordem alfabética.
    public function index()
    {
        $classLevels = ClassLevel::orderBy('classLevelName')->get();

        return view('admin.grade.all-grade.index', compact('classLevels'));
    }

    // Mostra o formulário para criar um nível de classe.
    public function create()
    {
        return view('admin.grade.add-grade.index');
    }

    // Guarda um novo nível de classe.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classLevelName' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        ClassLevel::create($validated);

        return redirect()
            ->route('class-levels.index')
            ->with('success', 'Nível de classe criado com sucesso.');
    }

    // Mostra os detalhes de um nível de classe.
    public function show(ClassLevel $classLevel)
    {
        return view('admin.classes.class-info.index', compact('classLevel'));
    }

    // Mostra o formulário para editar um nível de classe.
    public function edit(ClassLevel $classLevel)
    {
        return view('admin.classes.edit-class.index', compact('classLevel'));
    }

    // Atualiza um nível de classe.
    public function update(Request $request, ClassLevel $classLevel)
    {
        $validated = $request->validate([
            'classLevelName' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $classLevel->update($validated);

        return redirect()
            ->route('class-levels.index')
            ->with('success', 'Nível de classe atualizado com sucesso.');
    }

    // Elimina um nível de classe.
    public function destroy(ClassLevel $classLevel)
    {
        $classLevel->delete();

        return redirect()
            ->route('class-levels.index')
            ->with('success', 'Nível de classe eliminado com sucesso.');
    }
}
