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

{{-- Datatable (Bootstrap Table): pesquisa, paginação e escolha de colunas --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">

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

    /* Botões de ação (ver, aceitar, eliminar) */
    .enrollment-page .btn-action {
        width: 34px;
        height: 34px;
        padding: 0;
        margin: 0 .125rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .15s ease, color .15s ease;
    }

    .enrollment-page .btn-view {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .enrollment-page .btn-view:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .enrollment-page .btn-accept {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .enrollment-page .btn-accept:hover {
        background-color: #198754;
        color: #fff;
    }

    .enrollment-page .btn-delete {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .enrollment-page .btn-delete:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* Datatable: espaçamento da barra de pesquisa e da paginação dentro do cartão */
    .enrollment-page .fixed-table-toolbar {
        padding: 0 1.5rem;
    }

    .enrollment-page .fixed-table-pagination {
        padding: 0 1.5rem 1rem;
    }

    /* Esconde o texto "A mostrar X até Y de Z linhas" */
    .enrollment-page .fixed-table-pagination .pagination-info {
        display: none;
    }

    /* Barra de pesquisa maior */
    .enrollment-page .fixed-table-toolbar .search {
        min-width: 380px;
        max-width: 100%;
    }

    .enrollment-page .fixed-table-toolbar .search .search-input {
        height: 46px;
        font-size: 1.05rem;
        padding: 0 1rem;
    }

    @media (max-width: 575.98px) {
        .enrollment-page .fixed-table-toolbar .search {
            min-width: 0;
            width: 100%;
        }
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
                </nav>
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
                            {{-- Estado vazio: quando não há candidaturas --}}
                            @if ($enrollments->isEmpty())
                            <div class="px-4 py-5 text-center">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2" aria-hidden="true"></i>
                                    <p class="fw-semibold mb-1">Ainda não existem candidaturas.</p>
                                    <p class="small mb-0">
                                        As candidaturas submetidas aparecerão aqui.
                                    </p>
                                </div>
                            </div>
                            @else
                            {{-- Datatable de candidaturas (pesquisa, paginação e colunas) --}}
                            <table id="enrollmentsTable" class="table table-hover align-middle mb-0" data-toggle="table"
                                data-theme="bootstrap5" data-locale="pt-PT"
                                data-classes="table table-hover align-middle mb-0" data-pagination="true"
                                data-page-size="10" data-page-list="[10, 25, 50]" data-search="true">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="fullName">Nome completo</th>
                                        <th scope="col" data-field="phone">Telefone</th>
                                        <th scope="col" data-field="course">Curso pretendido</th>
                                        <th scope="col" data-field="applicationDate">Data da candidatura</th>
                                        <th scope="col" data-field="actions" data-searchable="false"
                                            data-switchable="false" data-halign="center" data-align="center">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <td>
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

                                        {{-- Ações: Detalhes, Aceitar e Eliminar --}}
                                        <td class="text-center text-nowrap">
                                            {{-- Ver detalhes da candidatura --}}
                                            <a class="btn-action btn-view"
                                                href="{{ route('enrollments.show', $enrollment) }}" title="Detalhes"
                                                aria-label="Detalhes">
                                                <i aria-hidden="true" class="bi bi-eye"></i>
                                            </a>

                                            {{-- Aceitar candidatura (POST protegido com CSRF) --}}
                                            <form class="d-inline"
                                                action="{{ route('enrollments.accept', $enrollment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-accept" title="Aceitar"
                                                    aria-label="Aceitar">
                                                    <i aria-hidden="true" class="bi bi-check-circle"></i>
                                                </button>
                                            </form>

                                            {{-- Eliminar candidatura (DELETE com confirmação) --}}
                                            <form class="d-inline"
                                                action="{{ route('enrollments.destroy', $enrollment) }}" method="POST"
                                                onsubmit="return confirm('Tem a certeza de que pretende eliminar esta candidatura?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Eliminar"
                                                    aria-label="Eliminar">
                                                    <i aria-hidden="true" class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Rodapé --}}
        {{--Rodapé--}}
        @include('layouts._include.dashboard.footer')
    </div>
</div>

{{-- Scripts da datatable (jQuery + Bootstrap Table + tradução pt-PT) --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/locale/bootstrap-table-pt-PT.min.js"></script>
@endsection