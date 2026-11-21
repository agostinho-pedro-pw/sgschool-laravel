<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::orderBy('nomeTurma')->get();

        return view('admin.turmas.all-turmas.index', compact('turmas'));
    }

    public function create()
    {
        $courses = $this->courses();

        return view('admin.turmas.add-turma.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomeTurma' => ['required', 'string', 'max:255'],
            'anoLetivo' => ['required', 'string', 'max:20'],
            'classe' => ['required', 'string', 'max:20'],
            'curso' => ['required', 'string', 'max:255'],
            'periodo' => ['required', 'in:manhã,tarde,noite'],
            'sala' => ['required', 'string', 'max:20'],
        ]);

        Turma::create($validated);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma criada com sucesso.');
    }

    public function show(Turma $turma)
    {
        return view('admin.turmas.turma-info.index', compact('turma'));
    }

    public function edit(Turma $turma)
    {
        $courses = $this->courses();

        return view('admin.turmas.edit-turma.index', compact('turma', 'courses'));
    }

    public function update(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'nomeTurma' => ['required', 'string', 'max:255'],
            'anoLetivo' => ['required', 'string', 'max:20'],
            'classe' => ['required', 'string', 'max:20'],
            'curso' => ['required', 'string', 'max:255'],
            'periodo' => ['required', 'in:manhã,tarde,noite'],
            'sala' => ['required', 'string', 'max:20'],
        ]);

        $turma->update($validated);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma atualizada com sucesso.');
    }

    public function destroy(Turma $turma)
    {
        $turma->delete();

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma eliminada com sucesso.');
    }

    // Lista fixa usada apenas pelo formulário da turma.
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
