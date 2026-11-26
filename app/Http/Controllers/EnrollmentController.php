<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Lista as inscrições e carrega os cursos relacionados.
    public function index()
    {
        $enrollments = Enrollment::with('course')
            ->orderByDesc('id')
            ->get();

        return view('admin.dashboard.enrollment-applications.index', compact('enrollments'));
    }

    // Mostra o formulário de criação com os cursos existentes.
    public function create()
    {
        $courses = Course::orderBy('courseName')->get();

        return view('admin.dashboard.enrollments.index', compact('courses'));
    }

    // Guarda uma nova inscrição e os caminhos dos documentos enviados.
    public function store(Request $request)
    {

        $data = $request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course_id',
        ]);

        if ($request->hasFile('bi')) {
            $data['biPath'] = $request->file('bi')->store('enrollments/bi', 'local');
        }

        if ($request->hasFile('certificado')) {
            $data['certificadoPath'] = $request->file('certificado')
                ->store('enrollments/certificados', 'local');
        }
        $data['applicationDate'] = now()->toDateString();
        Enrollment::create($data);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Inscrição criada com sucesso.');
    }

    // Mostra os dados de uma inscrição e o curso relacionado.
    public function show(Enrollment $enrollment)
    {
        $enrollment->load('course');

        return view('admin.dashboard.enrollment-applications.show', compact('enrollment'));
    }

    // Mostra o formulário de edição e carrega a lista de cursos.
    public function edit(Enrollment $enrollment)
    {
        $courses = Course::orderBy('courseName')->get();

        return view(
            'admin.dashboard.enrollment-applications.edit',
            compact('enrollment', 'courses')
        );
    }

    // Atualiza os dados e substitui documentos apenas quando novos ficheiros forem enviados.
    public function update(Request $request, Enrollment $enrollment)
    {
        $data = $request->only([
            'fullName',
            'dateOfBirth',
            'phone',
            'email',
            'gender',
            'course_id',
        ]);

        if ($request->hasFile('bi')) {
            $data['biPath'] = $request->file('bi')->store('enrollments/bi', 'local');
        }

        if ($request->hasFile('certificado')) {
            $data['certificadoPath'] = $request->file('certificado')
                ->store('enrollments/certificados', 'local');
        }

        $enrollment->update($data);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura atualizada com sucesso.');
    }

    // Marca uma candidatura como aceite.
    public function accept(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'accepted',
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura aceite com sucesso.');
    }

    // Elimina uma inscrição (soft delete, se o model usar SoftDeletes).
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Candidatura eliminada com sucesso.');
    }
}
