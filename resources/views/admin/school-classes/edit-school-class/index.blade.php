@extends('layouts.admin')

@section('title', 'Editar Classe Escolar - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Editar uma classe escolar">
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
                    <li class="breadcrumb-item"><a href="{{ route('school-classes.index') }}">Classes Escolares</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Classe</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Editar Classe Escolar</h1>
                <p class="text-muted mb-0">Atualize os dados da classe escolar.</p>
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
                    <form action="{{ route('school-classes.update', $schoolClass) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nomeTurma" class="form-label">Nome da Classe <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomeTurma" name="nomeTurma"
                                    value="{{ old('nomeTurma', $schoolClass->nomeTurma) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="anoLetivo" class="form-label">Ano Letivo <span class="text-danger">*</span></label>
                                <select class="form-select" id="anoLetivo" name="anoLetivo" required>
                                    @for ($ano = 2026; $ano <= 2035; $ano++)
                                    @php $anoLetivo = $ano . '/' . ($ano + 1); @endphp
                                    <option value="{{ $anoLetivo }}" @selected(old('anoLetivo', $schoolClass->anoLetivo) === $anoLetivo)>
                                        {{ $anoLetivo }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="classe" class="form-label">Classe <span class="text-danger">*</span></label>
                                <select class="form-select" id="classe" name="classe" required>
                                    @foreach (['10.ª', '11.ª', '12.ª', '13.ª classe'] as $classe)
                                    <option value="{{ $classe }}" @selected(old('classe', $schoolClass->classe) === $classe)>{{ $classe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="curso" class="form-label">Curso <span class="text-danger">*</span></label>
                                <select class="form-select" id="curso" name="curso" required>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course }}" @selected(old('curso', $schoolClass->curso) === $course)>
                                        {{ $course }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <span class="form-label d-block">Período <span class="text-danger">*</span></span>
                                @foreach (['manhã', 'tarde', 'noite'] as $periodo)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="periodo{{ $loop->index }}" name="periodo"
                                        value="{{ $periodo }}" @checked(old('periodo', $schoolClass->periodo) === $periodo) required>
                                    <label class="form-check-label" for="periodo{{ $loop->index }}">{{ ucfirst($periodo) }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <label for="sala" class="form-label">Sala <span class="text-danger">*</span></label>
                                <select class="form-select" id="sala" name="sala" required>
                                    @for ($numero = 1; $numero <= 12; $numero++)
                                    @php $sala = 'Sala-' . str_pad($numero, 2, '0', STR_PAD_LEFT); @endphp
                                    <option value="{{ $sala }}" @selected(old('sala', $schoolClass->sala) === $sala)>{{ $sala }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Atualizar Classe</button>
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
