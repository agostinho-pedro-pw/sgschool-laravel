{{-- Página: Lista de candidaturas de matrícula (herda o layout do painel admin) --}}
@extends('layouts.admin')

@section('title', 'Candidaturas de Matrícula')

@section('language', 'pt-PT')

{{-- Cabeçalho do HTML: meta tags, favicon, assets compilados e estilos da página --}}
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

    /* Hover das linhas da tabela */
    .enrollment-page .table-hover tbody tr {
        transition: background-color .15s ease;
    }

    .enrollment-page .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    /* Botão de 3 pontos (menu de ações) */
    .enrollment-page .btn-actions {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 50%;
        background: transparent;
        color: #6c757d;
        transition: background-color .15s ease, color .15s ease;
    }

    .enrollment-page .btn-actions:hover,
    .enrollment-page .btn-actions:focus,
    .enrollment-page .btn-actions.show {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .enrollment-page .btn-actions::after {
        display: none;
    }

    /* Itens do menu (botões dentro de formulários ocupam toda a largura) */
    .enrollment-page .dropdown-menu form {
        margin: 0;
    }

    .enrollment-page .dropdown-menu .dropdown-item {
        display: flex;
        align-items: center;
        gap: .5rem;
    }
</style>
@endsection

@section('content')
<div class="enrollment-page">
    {{-- Acessibilidade: saltar para o conteúdo principal --}}
    <a href="#main-content" class="visually-hidden-focusable">
        Saltar para o conteúdo principal
    </a>

    {{-- Elementos exigidos pelo script do painel (pesquisa e sidebar) --}}
    <div class="search-backdrop" id="searchBackdrop"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Barra lateral --}}
    @include('layouts._include.dashboard.sidebar')

    <div class="main-wrapper" id="mainWrapper">
        {{-- Cabeçalho superior: menu hambúrguer + breadcrumb --}}
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

        {{-- Conteúdo principal --}}
        <main class="dashboard-content" id="main-content">
            <div class="container-fluid">
                {{-- Mensagem de sucesso vinda do controller (ex.: candidatura aceite/eliminada) --}}
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <div class="dashboard-row">
                    {{-- Título da secção e botão para criar nova candidatura --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h2 class="h5 fw-semibold text-gray-800 mb-0">Candidaturas</h2>

                        <a href="{{ route('enrollments.create') }}" class="btn btn-primary">
                            Nova Candidatura
                        </a>
                    </div>

                    {{-- Garante que $enrollments existe, mesmo que o controller não o envie --}}
                    @php
                    $enrollments = $enrollments ?? collect();
                    @endphp

                    <div class="dashboard-card">
                        {{-- Cabeçalho do cartão com o total de candidaturas --}}
                        <div class="dashboard-card-header py-4 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Candidaturas submetidas</h6>

                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $enrollments->count() }}
                                </span>
                            </div>
                        </div>

                        <div class="dashboard-card-body p-0">
                            {{-- Tabela de candidaturas --}}
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Nome completo</th>
                                            <th scope="col" class="py-3">Telefone</th>
                                            <th scope="col" class="py-3">Curso pretendido</th>
                                            <th scope="col" class="py-3">Data da candidatura</th>
                                            <th scope="col" class="py-3 pe-4 text-end">Ações</th>
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

                                            {{-- Curso: converte o código guardado no nome legível (Enrollment::COURSES)
                                            --}}
                                            <td>
                                                @php
                                                $course = $enrollment->course ?? '-';
                                                $courses = \App\Models\Enrollment::COURSES ?? [];
                                                @endphp

                                                {{ $courses[$course] ?? $course }}
                                            </td>

                                            {{-- Data: aceita objeto de data ou texto e formata como dd/mm/aaaa --}}
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

                                            {{-- Ações: menu de 3 pontos (Detalhes, Aceitar, Eliminar) --}}
                                            <td class="pe-4 text-end">
                                                <div class="dropdown">
                                                    {{-- strategy "fixed" evita que o menu fique cortado pela tabela
                                                    responsiva --}}
                                                    <button type="button" class="btn-actions" data-bs-toggle="dropdown"
                                                        data-bs-popper-config='{"strategy":"fixed"}'
                                                        aria-expanded="false" aria-label="Ações da candidatura">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        {{-- Ver detalhes da candidatura --}}
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('enrollments.show', $enrollment) }}">
                                                                <i class="bi bi-eye"></i>Detalhes
                                                            </a>
                                                        </li>

                                                        {{-- Aceitar candidatura (POST protegido com CSRF) --}}
                                                        <li>
                                                            <form
                                                                action="{{ route('enrollments.accept', $enrollment) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bi bi-check-circle"></i>Aceitar
                                                                </button>
                                                            </form>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        {{-- Eliminar candidatura (DELETE com confirmação) --}}
                                                        <li>
                                                            <form
                                                                action="{{ route('enrollments.destroy', $enrollment) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Tem a certeza de que pretende eliminar esta candidatura?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash"></i>Eliminar
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Estado vazio: quando não há candidaturas --}}
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

        {{-- Rodapé --}}
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