{{-- Página com os detalhes de um departamento --}}
@extends('layouts.admin')

@section('title', 'Detalhes do Departamento - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Detalhes do departamento">
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

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Detalhes do Departamento</h1>
                    <p class="text-muted mb-0">Informações completa do departamento.</p>
                </div>

                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
                    Voltar à lista
                </a>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header py-4 px-4">
                    <h2 class="h5 mb-0">{{ $department->department_name }}</h2>
                </div>

                <div class="dashboard-card-body p-4">
                    <div class="row g-4">

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">ID</span>
                            <span class="fw-semibold">{{ $department->department_id }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Código</span>
                            <span class="badge bg-primary-subtle text-primary">
                                {{ $department->department_code }}
                            </span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Nome</span>
                            <span class="fw-semibold">{{ $department->department_name }}</span>
                        </div>

                        <div class="col-12">
                            <span class="small text-muted d-block">Descrição</span>
                            <span>{{ $department->description ?: '—' }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Criado em</span>
                            <span>{{ $department->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Atualizado em</span>
                            <span>{{ $department->updated_at?->format('d/m/Y H:i') ?? '—' }}</span>
                        </div>

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2" aria-hidden="true"></i>
                            Editar departamento
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection