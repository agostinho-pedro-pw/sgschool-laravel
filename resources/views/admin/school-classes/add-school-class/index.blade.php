{{-- Formulário para adicionar uma turma --}}
@extends('layouts.admin')

@section('title', 'Adicionar Classe Escolar - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Adicionar uma classe escolar">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    .dashboard-content {
        padding: 24px;
    }

    .class-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 1px 3px #0000001a;
    }

    .class-form-card-body {
        padding: 24px;
    }

    .class-form-card .form-label {
        font-weight: 500;
        margin-bottom: .5rem;
    }

    .class-form-card .form-control,
    .class-form-card .form-select {
        min-height: 44px;
        border-radius: 6px;
    }

    @media (max-width: 575.98px) {
        .dashboard-content {
            padding: 16px;
        }

        .class-form-card-body {
            padding: 18px;
        }
    }
</style>
@endsection

@section('content')
@php
$anosLetivos = [
'2026/2027', '2027/2028', '2028/2029', '2029/2030', '2030/2031',
'2031/2032', '2032/2033', '2033/2034', '2034/2035', '2035/2036',
];
$classes = ['10.ª', '11.ª', '12.ª', '13.ª classe'];
$periodos = ['manhã', 'tarde', 'noite'];
$salas = [
'Sala-01', 'Sala-02', 'Sala-03', 'Sala-04', 'Sala-05', 'Sala-06',
'Sala-07', 'Sala-08', 'Sala-09', 'Sala-10', 'Sala-11', 'Sala-12',
];
@endphp

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
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0"></ol>
            </nav>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Adicionar Turma</h1>
                <p class="text-muted mb-0">Criar uma nova turma.</p>
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

            <div class="class-form-card">
                <div class="class-form-card-body">
                    <form action="{{ route('school-classes.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nomeTurma" class="form-label">Nome da Turma <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomeTurma" name="nomeTurma"
                                    value="{{ old('nomeTurma') }}" placeholder="Ex.: 10.ª A" required>
                            </div>

                            <div class="col-md-6">
                                <label for="anoLetivo" class="form-label">Ano Letivo <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="anoLetivo" name="anoLetivo" required>
                                    <option value="">Selecione o ano letivo</option>
                                    @foreach ($anosLetivos as $anoLetivo)
                                    <option value="{{ $anoLetivo }}" @selected(old('anoLetivo')===$anoLetivo)>
                                        {{ $anoLetivo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="classe" class="form-label">Classe <span class="text-danger">*</span></label>
                                <select class="form-select" id="classe" name="classe" required>
                                    <option value="">Selecione a classe</option>
                                    @foreach ($classes as $classe)
                                    <option value="{{ $classe }}" @selected(old('classe')===$classe)>
                                        {{ $classe }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="course_id" class="form-label">Curso <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="course_id" name="course_id" required>
                                    <option value="">Selecione um curso</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected((string) old('course_id')===(string)
                                        $course->id)>
                                        {{ $course->courseCode }} - {{ $course->courseName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <span class="form-label d-block">Período <span class="text-danger">*</span></span>
                                @foreach ($periodos as $periodo)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="periodo{{ $loop->index }}"
                                        name="periodo" value="{{ $periodo }}" @checked(old('periodo', 'manhã'
                                        )===$periodo) required>
                                    <label class="form-check-label" for="periodo{{ $loop->index }}">
                                        {{ ucfirst($periodo) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                <label for="sala" class="form-label">Sala <span class="text-danger">*</span></label>
                                <select class="form-select" id="sala" name="sala" required>
                                    <option value="">Selecione a sala</option>
                                    @foreach ($salas as $sala)
                                    <option value="{{ $sala }}" @selected(old('sala')===$sala)>
                                        {{ $sala }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2" aria-hidden="true"></i>Criar Turma
                                </button>
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