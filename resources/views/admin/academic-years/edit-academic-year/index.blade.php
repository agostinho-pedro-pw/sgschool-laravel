@extends('layouts.admin')

@section('title', 'Editar Ano Letivo - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Editar um ano letivo">
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
                    <li class="breadcrumb-item active" aria-current="page">Editar Ano Letivo</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Editar Ano Letivo</h1>
                <p class="text-muted mb-0">Atualize os dados do ano letivo.</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="dashboard-card">
                <div class="dashboard-card-body">
                    <form action="{{ route('academic-years.update', $academicYear) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designação <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $academicYear->designation) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Data de Início <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $academicYear->start_date) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Data de Fim <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $academicYear->end_date) }}" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Atualizar Ano Letivo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('layouts._include.dashboard.footer')
</div>
@endsection
