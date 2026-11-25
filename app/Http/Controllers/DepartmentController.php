<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    // Lista todos os departamentos por ordem alfabética do nome
    public function index(): View
    {
        $departments = Department::orderBy('department_name')->get();

        return view('admin.departments.departments.index', compact('departments'));
    }

    // Mostra o formulário para criar um departamento
    public function create(): View
    {
        return view('admin.departments.add-department.index');
    }

    // Guarda um novo departamento
    public function store(Request $request): RedirectResponse
    {
        Department::create($request->only([
            'department_name',
            'department_code',
            'description',
        ]));

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departamento criado com sucesso.');
    }
    public function show(Department $department)
    {
        return view('admin.departments.all-departments.index', compact('department'));
    }

    // Mostra o formulário para editar um departamento
    public function edit(Department $department): View
    {
        return view('admin.departments.edit-department.index', compact('department'));
    }

    // Atualiza os dados de um departamento
    public function update(Request $request, Department $department): RedirectResponse
    {
        $department->update($request->only([
            'department_name',
            'department_code',
            'description',
        ]));

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departamento atualizado com sucesso.');
    }

    // Elimina um departamento
    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departamento eliminado com sucesso.');
    }
}
