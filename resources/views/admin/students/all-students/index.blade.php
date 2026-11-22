@extends('layouts.admin')

@section('title', 'Matrículas - sgSchool')
@section('language', 'pt-PT')

@section('head')
<style>
    /* Estilos limitados à página de listagem de matrículas. */
    #registration-list-page.dashboard-content {
        min-height: calc(100vh - 60px);
        padding: clamp(1rem, 2.5vw, 2rem);
        background: #f5f7fb;
    }

    #registration-list-page .registration-heading h1 {
        color: #172033;
        letter-spacing: -.025em;
    }

    #registration-list-page .registration-heading p {
        color: #64748b;
    }

    #registration-list-page .registration-add-button {
        min-height: 44px;
        padding: .65rem 1rem;
        border-radius: 8px;
        background: #2563eb;
        border-color: #1d4ed8;
        font-weight: 600;
        white-space: nowrap;
    }

    #registration-list-page .registration-card {
        overflow: hidden;
        border: 1px solid #e5eaf1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    #registration-list-page .registration-table {
        min-width: 850px;
        margin-bottom: 0;
    }

    #registration-list-page .registration-table thead th {
        padding: 1rem .9rem;
        border-bottom: 1px solid #e5eaf1;
        background: #f8fafc;
        color: #475569;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .045em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    #registration-list-page .registration-table tbody td {
        padding: .95rem .9rem;
        border-color: #edf1f5;
        color: #334155;
        vertical-align: middle;
    }

    #registration-list-page .student-name {
        color: #172033;
        font-weight: 600;
    }

    #registration-list-page .registration-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        min-width: 190px;
    }

    #registration-list-page .registration-actions .btn {
        border-radius: 7px;
    }

    #registration-list-page .empty-registrations {
        padding: 3rem 1rem !important;
        color: #64748b;
    }

    @media (max-width: 767.98px) {
        #registration-list-page.dashboard-content {
            padding: 1rem .75rem;
        }

        #registration-list-page .registration-heading {
            align-items: flex-start !important;
            flex-direction: column;
        }

        #registration-list-page .registration-add-button {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    <header class="navbar top-navbar">
        <div class="container-fluid">
            <button type="button" class="hamburger-menu" id="sidebarToggle"
                aria-label="Abrir ou fechar a barra lateral">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Navegação estrutural" class="ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Matrículas</li>
                </ol>
            </nav>
        </div>
    </header>

    <main class="dashboard-content" id="registration-list-page">
        <div class="container-fluid">
            <div class="registration-heading d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Matrículas</h1>
                    <p class="mb-0">Consultar e gerir matrículas de estudantes.</p>
                </div>
                <a href="{{ route('add-students') }}" class="btn btn-primary registration-add-button">
                    <i class="bi bi-plus-lg me-2"></i>Adicionar matrícula
                </a>
            </div>

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            @php
            // Traduz os valores guardados como texto, sem consultar outras tabelas.
            $courseLabels = [
            'informatica-gestao' => 'Informática de Gestão',
            'informatica-sistemas-multimedia' => 'Informática, Sistemas e Multimédia',
            'eletronica-telecomunicacoes' => 'Eletrónica e Telecomunicações',
            'analises-clinicas' => 'Análises Clínicas',
            ];
            $periodLabels = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
            @endphp

            <div class="dashboard-card registration-card">
                <div class="dashboard-card-body table-responsive p-0">
                    <table class="table table-hover align-middle registration-table">
                        <thead>
                            <tr>
                                <th>Estudante</th>
                                <th>Curso</th>
                                <th>Classe/Turma</th>
                                <th>Sala</th>
                                <th>Período</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($registrations as $registration)
                            <tr>
                                <td class="student-name">{{ $registration->fullName }}</td>
                                <td>{{ $courseLabels[$registration->course] ?? $registration->course }}</td>
                                <td>{{ $registration->schoolClass }}</td>
                                <td>{{ $registration->room }}</td>
                                <td>{{ $periodLabels[$registration->period] ?? $registration->period }}</td>
                                <td>
                                    <div class="registration-actions">
                                        <a href="{{ route('registrations.show', $registration) }}"
                                            class="btn btn-sm btn-outline-primary">Detalhes</a>
                                        <a href="{{ route('registrations.edit', $registration) }}"
                                            class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form action="{{ route('registrations.destroy', $registration) }}" method="POST"
                                            onsubmit="return confirm('Eliminar esta matrícula?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center empty-registrations">
                                    Ainda não existem matrículas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection