{{-- Página com os detalhes de uma classe escolar --}}
@extends('layouts.admin')

@section('title', 'Detalhes da Classe - sgSchool')
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
                    <h1 class="h3 mb-1 text-gray-800">Detalhes da Classe</h1>
                    <p class="text-muted mb-0">Informações completas da classe escolar.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('classes.edit', $classLevel) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1" aria-hidden="true"></i>Editar Classe
                    </a>
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar à Lista
                    </a>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="dashboard-card">
                <div class="dashboard-card-header py-4 px-4">
                    <h2 class="h5 mb-0">{{ $classLevel->nome_classe }}</h2>
                </div>
                <div class="dashboard-card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">ID</span>
                            <span class="fw-semibold">{{ $classLevel->id_classe }}</span>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Nome da Classe</span>
                            <span class="fw-semibold">{{ $classLevel->nome_classe }}</span>
                        </div>
                        <div class="col-12">
                            <span class="small text-muted d-block">Descrição</span>
                            <span>{{ $classLevel->descricao ?: '—' }}</span>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Criada em</span>
                            <span>{{ $classLevel->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Atualizada em</span>
                            <span>{{ $classLevel->updated_at?->format('d/m/Y H:i') ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection