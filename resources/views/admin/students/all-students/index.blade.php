@extends('layouts.admin')

@section('title', 'Listar Matrículas - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Lista de matrículas de estudantes">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    /* Estilos locais da tabela de matrículas, sem redefinir o layout do painel. */
    #registrationTable th,
    #registrationTable td {
        /* Mais espaço dentro das células */
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    #registrationTable thead th {
        white-space: nowrap;
        color: #475569;
        font-size: .82rem;
    }

    #registrationTable tbody td {
        color: #334155;
    }

    .registration-list-card {
        /* Sem overflow: assim não aparece a barra de scroll nem o menu de ações fica cortado */
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .registration-name {
        color: #172033;
        font-weight: 600;
    }

    /* Menu de ações: espaçamento e transição suave */
    #registrationTable .dropdown-menu {
        padding: .375rem
    }

    #registrationTable .dropdown-item {
        border-radius: 6px;
        padding: .5rem .75rem;
        transition: background-color .15s ease, transform .15s ease
    }

    /* Hover de Detalhes e Editar */
    #registrationTable .dropdown-menu .dropdown-item:hover,
    #registrationTable .dropdown-menu .dropdown-item:focus {
        background-color: #cbd5e1 !important;
        transform: translateX(3px)
    }

    /* Hover de Eliminar (vermelho claro) */
    #registrationTable .dropdown-menu .dropdown-item.text-danger:hover,
    #registrationTable .dropdown-menu .dropdown-item.text-danger:focus {
        background-color: #fecaca !important
    }
</style>
@endsection

@section('content')
<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle"
                aria-label="Abrir ou fechar a barra lateral">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Matrículas</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Listar Matrículas</h1>
                    <p class="text-muted mb-0">Consultar e gerir as matrículas dos estudantes.</p>
                </div>
                <a href="{{ route('add-students') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Adicionar Matrícula
                </a>
            </div>

            @php
            // Mostra nomes legíveis sem consultar nem relacionar outras tabelas.
            $courseLabels = [
            'informatica-gestao' => 'Informática de Gestão',
            'informatica-sistemas-multimedia' => 'Informática, Sistemas e Multimédia',
            'eletronica-telecomunicacoes' => 'Eletrónica e Telecomunicações',
            'analises-clinicas' => 'Análises Clínicas',
            ];
            $shiftLabels = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
            @endphp

            <div class="registration-list-card">
                <table class="table table-hover align-middle mb-0" id="registrationTable">
                    <thead>
                        <tr>
                            <th scope="col">Estudante</th>
                            <th scope="col">N.º estudante</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Turma</th>
                            <th scope="col">Ano lectivo</th>
                            <th scope="col">Sala</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Acções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $registration)
                        <tr>
                            <td class="registration-name">{{ $registration->fullName }}</td>
                            <td>{{ $registration->studentId ?? '—' }}</td>
                            <td>{{ $courseLabels[$registration->course] ?? $registration->course ?? '—' }}</td>
                            <td>{{ $registration->schoolClass ?? '—' }}</td>
                            <td>{{ $registration->academicYear ?? '—' }}</td>
                            <td>{{ $registration->room ?? '—' }}</td>
                            <td>{{ $shiftLabels[$registration->turno ?? ''] ?? $registration->turno ?? '—' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        aria-label="Mais opções da matrícula">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('registrations.show', $registration) }}">
                                                <i class="bi bi-eye me-2"></i>Detalhes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('registrations.edit', $registration) }}">
                                                <i class="bi bi-pencil me-2"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('registrations.destroy', $registration) }}"
                                                method="POST" onsubmit="return confirm('Eliminar esta matrícula?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Eliminar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center text-muted">Nenhuma matrícula encontrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($registrations, 'links'))
            <div class="mt-4 d-flex justify-content-center">
                {{ $registrations->links() }}
            </div>
            @endif
        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection