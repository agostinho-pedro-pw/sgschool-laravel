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

    .enrollment-page .table-hover tbody tr {
        transition: background-color .15s ease;
    }

    .enrollment-page .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

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

    .enrollment-page .fixed-table-toolbar {
        padding: 0 1.5rem;
    }

    .enrollment-page .fixed-table-pagination {
        padding: 0 1.5rem 1rem;
    }

    .enrollment-page .fixed-table-pagination .pagination-info {
        display: none;
    }

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
                </nav>
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
                    <div class="mb-4">
                        <h2 class="h5 fw-semibold text-gray-800 mb-0">Candidaturas</h2>
                    </div>
                    @php
                    $enrollments = $enrollments ?? collect();

                    // Linhas usadas pelo botão "Exportar" (CSV)
                    $exportRows = $enrollments->map(function ($e) {
                    $date = $e->applicationDate ?? null;
                    });
                    @endphp

                    <div class="dashboard-card">
                        <div class="dashboard-card-header py-4 px-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="mb-0">Candidaturas submetidas</h5>

                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $enrollments->count() }}
                                    </span>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <input type="search" id="enrollmentSearch" class="form-control"
                                        placeholder="Pesquisar candidaturas..." aria-label="Pesquisar candidaturas"
                                        style="width: 260px" @disabled($enrollments->isEmpty())>
                                    <button type="button" id="exportEnrollments" class="btn btn-outline-primary"
                                        @disabled($enrollments->isEmpty())>
                                        <i class="bi bi-download me-1" aria-hidden="true"></i>Exportar
                                    </button>
                                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus me-1" aria-hidden="true"></i>Nova Candidatura
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard-card-body p-0">
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
                            <table id="enrollmentsTable" class="table table-custom table-hover align-middle mb-0"
                                data-toggle="table" data-theme="bootstrap5" data-locale="pt-PT"
                                data-classes="table table-custom table-hover align-middle mb-0" data-pagination="true"
                                data-page-size="10" data-page-list="[10, 25, 50]" data-search="true"
                                data-search-selector="#enrollmentSearch">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="fullName">Candidato</th>
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
                                        <td class="py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($enrollment->fullName ?? 'Candidato') }}&background=6366f1&color=fff"
                                                    alt="{{ $enrollment->fullName ?? 'Candidato' }}"
                                                    class="student-avatar rounded-circle me-2"
                                                    style="width: 32px; height: 32px; object-fit: cover;" loading="lazy"
                                                    decoding="async">

                                                <span class="student-name">{{ $enrollment->fullName ?? '—' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-nowrap py-2">
                                            {{ $enrollment->phone ?? '—' }}
                                        </td>
                                        <td class="py-2">
                                            {{ $enrollment->course
                                            ? $enrollment->course->courseName
                                            : ' — ' }}
                                        </td>
                                        <td class="text-nowrap py-2">
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
                                        <td class="text-center text-nowrap py-2">
                                            <a class="btn-action btn-view"
                                                href="{{ route('enrollments.show', $enrollment) }}" title="Detalhes"
                                                aria-label="Detalhes">
                                                <i aria-hidden="true" class="bi bi-eye"></i>
                                            </a>
                                            <form class="d-inline"
                                                action="{{ route('enrollments.accept', $enrollment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-accept" title="Aceitar"
                                                    aria-label="Aceitar">
                                                    <i aria-hidden="true" class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
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
        @include('layouts._include.dashboard.footer')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/locale/bootstrap-table-pt-PT.min.js"></script>
<script>
    const exportButton = document.getElementById('exportEnrollments');

    if (exportButton) {
        // Dados vindos do PHP (variável $exportRows)
        const rows = @json($exportRows);

        exportButton.addEventListener('click', function () {
            if (rows.length === 0) return;

            // Primeira linha do CSV: nomes das colunas (Nome, Email, ...)
            const headers = Object.keys(rows[0]);
            const lines = [headers.join(';')];

            // Uma linha por candidatura, com os valores entre aspas
            rows.forEach(function (row) {
                const values = headers.map(function (h) {
                    return '"' + String(row[h]).replace(/"/g, '""') + '"';
                });
                lines.push(values.join(';'));
            });

            // Cria o ficheiro e inicia o download (﻿ mantém os acentos no Excel)
            const file = new Blob(['﻿' + lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.download = 'candidaturas.csv';
            link.click();
        });
    }
</script>
@endsection