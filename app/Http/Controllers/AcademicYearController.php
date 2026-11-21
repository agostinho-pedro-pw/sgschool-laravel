<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    // Lista todos os anos letivos.
    public function index(): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();

        return view('admin.academic-years.all-academic-years.index', compact('academicYears'));
    }

    // Mostra o formulário para criar um ano letivo.
    public function create(): View
    {
        return view('admin.academic-years.add-academic-year.index');
    }

    // Guarda um novo ano letivo.
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'designation' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        AcademicYear::create($validated);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Ano letivo criado com sucesso.');
    }

    // Mostra os detalhes de um ano letivo.
    public function show(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.academic-year-info.index', compact('academicYear'));
    }

    // Mostra o formulário para editar um ano letivo.
    public function edit(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.edit-academic-year.index', compact('academicYear'));
    }

    // Atualiza um ano letivo.
    public function update(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        $validated = $request->validate([
            'designation' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        $academicYear->update($validated);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Ano letivo atualizado com sucesso.');
    }

    // Elimina um ano letivo.
    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $academicYear->delete();

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Ano letivo eliminado com sucesso.');
    }
}
