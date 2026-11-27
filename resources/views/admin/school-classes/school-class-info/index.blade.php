@extends('layouts.admin')

@section('title', 'Detalhes da Classe Escolar - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Detalhes da classe escolar">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    .dashboard-content {
        padding: 24px;
    }

    @media (max-width: 575.98px) {
        .dashboard-content {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')
<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
<div class="search-backdrop" id="searchBackdrop"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Abrir ou fechar a barra lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Detalhes da Turma</h1>
                    <p class="text-muted mb-0">Informações completas da turma.</p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('school-classes.edit', $schoolClass) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1" aria-hidden="true"></i>Editar Classe
                    </a>
                    <a href="{{ route('school-classes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar à Lista
                    </a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header py-4 px-4">
                    <h2 class="h5 mb-0">{{ $schoolClass->nomeTurma }}</h2>
                </div>

                <div class="dashboard-card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Nome da Turma</span>
                            <span class="fw-semibold">{{ $schoolClass->nomeTurma }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Classe</span>
                            <span class="fw-semibold">{{ $schoolClass->classLevel?->nome_classe ?? 'Sem classe
                                associada' }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Curso</span>
                            <span class="fw-semibold">
                                {{ $schoolClass->course?->courseName ?? 'Sem curso associado' }}
                            </span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Período</span>
                            <span class="fw-semibold">{{ ucfirst($schoolClass->periodo) }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Sala</span>
                            <span class="fw-semibold">
                                {{ $schoolClass->room?->designacao ?? 'Sem sala associada' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection