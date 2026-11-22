<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Lista as matrículas.
    public function index()
    {
        $registrations = Registration::orderByDesc('id')->get();

        return view('admin.students.all-students.index', compact('registrations'));
    }

    // Abre o formulário para criar uma matrícula.
    public function create()
    {
        return view('admin.students.add-student.index');
    }

    // Guarda uma matrícula.
    public function store(Request $request)
    {
        Registration::create($request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course',
            'schoolClass',
            'room',
            'period',
        ]));

        return redirect()
            ->route('all-students')
            ->with('success', 'Matrícula criada com sucesso.');
    }

    // Mostra uma matrícula.
    public function show(Registration $registration)
    {
        return view('admin.students.student-profile.index', compact('registration'));
    }

    // Abre o formulário para editar uma matrícula.
    public function edit(Registration $registration)
    {
        return view('admin.students.edit-students.index', compact('registration'));
    }

    // Atualiza uma matrícula.
    public function update(Request $request, Registration $registration)
    {
        $registration->update($request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course',
            'schoolClass',
            'room',
            'period',
        ]));

        return redirect()
            ->route('all-students')
            ->with('success', 'Matrícula atualizada com sucesso.');
    }

    // Elimina uma matrícula.
    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()
            ->route('all-students')
            ->with('success', 'Matrícula eliminada com sucesso.');
    }
}
