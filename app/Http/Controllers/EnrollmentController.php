<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{

    // Lista as matrículas
    public function index()
    {
        $enrollments = Enrollment::orderByDesc('id')->get();

        return view('admin.dashboard.enrollment-applications.index', compact('enrollments'));
    }

    // Mostra o formulário de matrícula
    public function create()
    {
        return view('admin.dashboard.enrollments.index');
    }

    // Guarda uma inscrição
    public function store(Request $request)
    {
        // dd($request->all());
        Enrollment::create($request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course',
            'schoolClass',
            'room',
            'period',
        ]) + [
            'applicationDate' => today(),
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura criada com sucesso.');
    }

    // Mostra os dados de uma inscrição
    public function show(Enrollment $enrollment)
    {
        return view('admin.dashboard.enrollment-applications.show', compact('enrollment'));
    }

    // Mostra o formulário de edição
    public function edit(Enrollment $enrollment)
    {
        return view('admin.dashboard.enrollment-applications.edit', compact('enrollment'));
    }

    // Atualiza uma inscrição
    public function update(Request $request, Enrollment $enrollment)
    {
        $enrollment->update($request->only([
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
            ->route('enrollments.index')
            ->with('success', 'Candidatura atualizada com sucesso.');
    }

    // Aceita uma candidatura
    public function accept(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'accepted',
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura aceite com sucesso.');
    }

    // Elimina uma inscrição
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura eliminada com sucesso.');
    }
}
