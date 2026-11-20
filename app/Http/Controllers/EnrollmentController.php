<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Lista as inscrições
    public function index()
    {
        $enrollments = Enrollment::orderByDesc('applicationDate')
            ->orderByDesc('id')
            ->get();

        return view('admin.dashboard.enrollment-applications.index', compact('enrollments'));
    }

    // Mostra o formulário
    public function create()
    {
        return view('admin.dashboard.enrollments.index');
    }

    // Guarda uma inscrição
    public function store(Request $request)
    {
        Enrollment::create($request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course',
        ]) + [
            'applicationDate' => today(),
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'A sua candidatura foi submetida com sucesso.');
    }

    // Mostra os dados de uma inscrição
    public function show(Enrollment $enrollment)
    {
        return view('admin.dashboard.enrollment-applications.show', compact('enrollment'));
    }

    // Mostra o formulário de edição
    public function edit(Enrollment $enrollment)
    {
        return view('admin.dashboard.enrollments.index', compact('enrollment'));
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
        ]));

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'A inscrição foi atualizada com sucesso.');
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
            ->with('success', 'A candidatura foi eliminada com sucesso.');
    }
}
