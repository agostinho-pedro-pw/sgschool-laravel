<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // Lista todas as classes escolares por ordem alfabética
    public function index()
    {
        $schoolClasses = SchoolClass::orderBy('nomeTurma')->get();

        return view('admin.school-classes.all-school-classes.index', compact('schoolClasses'));
    }

    // Mostra o formulário para criar uma classe escolar
    public function create()
    {
        $courses = $this->courses();

        return view('admin.school-classes.add-school-class.index', compact('courses'));
    }

    // Guarda uma nova classe escolar
    public function store(Request $request)
    {
        SchoolClass::create($request->only([
            'nomeTurma',
            'anoLetivo',
            'classe',
            'curso',
            'periodo',
            'sala',
        ]));

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Classe escolar criada com sucesso.');
    }

    // Mostra os detalhes de uma classe escolar
    public function show(SchoolClass $schoolClass)
    {
        return view('admin.school-classes.school-class-info.index', compact('schoolClass'));
    }

    // Mostra o formulário para editar uma classe escolar
    public function edit(SchoolClass $schoolClass)
    {
        $courses = $this->courses();

        return view('admin.school-classes.edit-school-class.index', compact('schoolClass', 'courses'));
    }

    // Atualiza uma classe escolar
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $schoolClass->update($request->only([
            'nomeTurma',
            'anoLetivo',
            'classe',
            'curso',
            'periodo',
            'sala',
        ]));

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Classe escolar atualizada com sucesso.');
    }

    // Elimina uma classe escolar
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()
            ->route('school-classes.index')
            ->with('success', 'Classe escolar eliminada com sucesso.');
    }

    // Lista fixa usada apenas pelo formulário da classe escolar.
    private function courses(): array
    {
        return [
            'Ciências Económico-Jurídicas',
            'Ciências Humanas',
            'Ciências Físicas e Biológicas',
            'Informática',
            'Contabilidade',
            'Multimédia',
        ];
    }
}
