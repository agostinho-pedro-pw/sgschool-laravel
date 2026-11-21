@extends('layouts.admin')

@section('title', 'Detalhes do Ano Letivo - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Detalhes do ano letivo">
<link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/dist/assets/favicon-9EIT7vLh.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0 }
    body { background: #f5f7fa; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif }
    .sidebar { z-index: 1040; background: #1f2937; width: 260px; height: 100vh; position: fixed; top: 0; left: 0 }
    .main-wrapper { min-height: 100vh; margin-left: 260px; transition: margin-left .3s }
    .top-navbar { background: #fff; height: 60px; padding: 0 1rem; box-shadow: 0 1px 3px #0000001a }
    .dashboard-content { padding: 24px }
    .dashboard-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 3px #0000001a }
    .dashboard-card-body { padding: 24px }
</style>
@endsection

@section('content')
<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Abrir ou fechar a barra lateral">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('academic-years.index') }}">Anos Letivos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Detalhes do Ano Letivo</h1>
                    <p class="text-muted mb-0">Informações completas do ano letivo.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('academic-years.edit', $academicYear) }}" class="btn btn-primary">Editar Ano Letivo</a>
                    <a href="{{ route('academic-years.index') }}" class="btn btn-outline-secondary">Voltar à Lista</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-body">
                    <h2 class="h5 fw-bold mb-4">Informações do Ano Letivo</h2>
                    <div class="row">
                        <div class="col-12 border-bottom py-3"><div class="fw-semibold text-muted mb-1">Designação</div><div>{{ $academicYear->designation }}</div></div>
                        <div class="col-12 border-bottom py-3"><div class="fw-semibold text-muted mb-1">Data de Início</div><div>{{ date('d/m/Y', strtotime($academicYear->start_date)) }}</div></div>
                        <div class="col-12 py-3"><div class="fw-semibold text-muted mb-1">Data de Fim</div><div>{{ date('d/m/Y', strtotime($academicYear->end_date)) }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts._include.dashboard.footer')
</div>
@endsection
