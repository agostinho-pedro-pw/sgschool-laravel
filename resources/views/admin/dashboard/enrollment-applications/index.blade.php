@extends('layouts.admin')

@section('title', 'Candidaturas de Matrícula')

@section('language', 'pt-PT')

@section('head')
<meta name="description" content="sgSchool - Candidaturas de matrícula">
<meta name="keywords" content="educação, candidatura, matrícula, estudante">
<meta name="author" content="Agostinho Pedro">

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">

<style>
    .enrollment-page .dashboard-content {
        padding: 24px;
    }

    @media (max-width: 575.98px) {
        .enrollment-page .dashboard-content {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="enrollment-page">
    <a href="#main-content" class="visually-hidden-focusable">
        Saltar para o conteúdo principal
    </a>

    <div class="search-backdrop" id="searchBackdrop"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @include('layouts._include.dashboard.sidebar')

    <div class="main-wrapper" id="mainWrapper">
        <header class="navbar top-navbar">
            <div class="container-fluid d-flex align-items-center h-100">
                <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Alternar barra lateral"
                    aria-controls="sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <nav aria-label="Navegação estrutural do cabeçalho" class="d-none d-lg-block ms-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Início</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Inscrições
                        </li>
                    </ol>
                </nav>

                <div class="navbar-brand d-lg-none fw-bold me-auto">
                    sgSchool
                </div>
            </div>
        </header>

        <main class="dashboard-content" id="main-content">
            <div class="container-fluid">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <div class="dashboard-row">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h2 class="h5 fw-semibold text-gray-800 mb-0">Candidaturas</h2>

                        <a href="{{ route('enrollments.create') }}" class="btn btn-primary">
                            Nova Candidatura
                        </a>
                    </div>

                    @php
                    $enrollments = $enrollments ?? collect();
                    @endphp

                    <div class="dashboard-card">
                        <div class="dashboard-card-header py-4 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Candidaturas submetidas</h6>

                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $enrollments->count() }}
                                </span>
                            </div>
                        </div>

                        <div class="dashboard-card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Nome completo</th>
                                            <th scope="col" class="py-3">Telefone</th>
                                            <th scope="col" class="py-3">Curso pretendido</th>
                                            <th scope="col" class="py-3">Data da candidatura</th>
                                            <th scope="col" class="py-3 pe-4">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($enrollments as $enrollment)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-semibold">
                                                    {{ $enrollment->fullName ?? '—' }}
                                                </div>
                                            </td>

                                            <td class="text-nowrap">
                                                {{ $enrollment->phone ?? '—' }}
                                            </td>

                                            <td>
                                                @php
                                                $course = $enrollment->course ?? '-';
                                                $courses = \App\Models\Enrollment::COURSES ?? [];
                                                @endphp

                                                {{ $courses[$course] ?? $course }}
                                            </td>

                                            <td class="text-nowrap">
                                                @php
                                                $applicationDate = $enrollment->applicationDate ?? null;
                                                @endphp

                                                @if ($applicationDate instanceof \DateTimeInterface)
                                                {{ $applicationDate->format('d/m/Y') }}
                                                @elseif ($applicationDate)
                                                {{ \Carbon\Carbon::parse($applicationDate)->format('d/m/Y') }}
                                                @else
                                                —
                                                @endif
                                            </td>

                                            <td class="pe-4">
                                                <div class="d-flex gap-2 text-nowrap">
                                                    <a href="{{ route('enrollments.show', $enrollment) }}"
                                                        class="btn btn-sm btn-primary">
                                                        Detalhes
                                                    </a>

                                                    <form action="{{ route('enrollments.accept', $enrollment) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-secondary">
                                                            Aceitar
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('enrollments.destroy', $enrollment) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Tem a certeza de que pretende eliminar esta candidatura?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-5 text-center">
                                                <div class="text-muted">
                                                    <i class="bi bi-inbox fs-2 d-block mb-2" aria-hidden="true"></i>
                                                    <p class="fw-semibold mb-1">Ainda não existem candidaturas.</p>
                                                    <p class="small mb-0">
                                                        As candidaturas submetidas aparecerão aqui.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="dashboard-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2026 sgSchool. Todos os direitos reservados.</p>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Criado com para a educação</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection