<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use Illuminate\Http\Request;

class ClassLevelController extends Controller
{
    // Lista as classes por ordem alfabética.
    public function index()
    {
        $classLevels = ClassLevel::orderBy('nome_classe')->get();

        return view('admin.grade.all-grade.index', compact('classLevels'));
    }

    // Mostra o formulário para criar uma classe.
    public function create()
    {
        return view('admin.grade.add-grade.index');
    }

    // Guarda uma nova classe.
    public function store(Request $request)
    {
        ClassLevel::create($request->only([
            'nome_classe',
            'descricao',
        ]));

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe criada com sucesso.');
    }

    // Mostra os detalhes de uma classe.
    public function show(ClassLevel $classLevel)
    {
        return view('admin.classes.class-info.index', compact('classLevel'));
    }

    // Mostra o formulário para editar uma classe.
    public function edit(ClassLevel $classLevel)
    {
        return view('admin.classes.edit-class.index', compact('classLevel'));
    }

    // Atualiza os dados de uma classe.
    public function update(Request $request, ClassLevel $classLevel)
    {
        $classLevel->update($request->only([
            'nome_classe',
            'descricao',
        ]));

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe atualizada com sucesso.');
    }

    // Elimina uma classe.
    public function destroy(ClassLevel $classLevel)
    {
        $classLevel->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe eliminada com sucesso.');
    }
}
