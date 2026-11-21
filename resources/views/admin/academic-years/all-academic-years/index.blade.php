@extends('layouts.admin')

@section('title', 'Listar Anos Letivos - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Lista de anos letivos">
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
    #academicYearTable th, #academicYearTable td { padding: 1rem 1.25rem }
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
                    <li class="breadcrumb-item active" aria-current="page">Anos Letivos</li>
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
                    <h1 class="h3 fw-bold mb-1">Listar Anos Letivos</h1>
                    <p class="text-muted mb-0">Gerir os anos letivos da instituição.</p>
                </div>
                <a href="{{ route('academic-years.create') }}" class="btn btn-primary">Adicionar Ano Letivo</a>
            </div>

            <div class="dashboard-card">
                <table class="table table-hover align-middle mb-0" id="academicYearTable">
                    <thead>
                        <tr>
                            <th scope="col">Designação</th>
                            <th scope="col">Data de Início</th>
                            <th scope="col">Data de Fim</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($academicYears as $academicYear)
                        <tr>
                            <td class="fw-semibold">{{ $academicYear->designation }}</td>
                            <td>{{ date('d/m/Y', strtotime($academicYear->start_date)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($academicYear->end_date)) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Mais opções">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('academic-years.show', $academicYear) }}"><i class="bi bi-eye me-2"></i>Detalhes</a></li>
                                        <li><a class="dropdown-item" href="{{ route('academic-years.edit', $academicYear) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('academic-years.destroy', $academicYear) }}" method="POST" onsubmit="return confirm('Eliminar este ano letivo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Eliminar</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-muted">Nenhum ano letivo encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @include('layouts._include.dashboard.footer')
</div>
@endsection
