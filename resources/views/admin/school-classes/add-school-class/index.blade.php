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
// Declaração de variáveis constantes no projeto
$periodos = ['manhã', 'tarde', 'noite'];
@endphp

<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
<div class="search-backdrop" id="searchBackdrop"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
{{--SideBar--}}
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
                                <label for="class_level_id" class="form-label">Classe</label>

                                <select name="class_level_id" id="class_level_id" class="form-select">
                                    <option value="">Selecione uma classe</option>

                                    @foreach ($classLevels as $classLevel)
                                    <option value="{{ $classLevel->id_classe }}">
                                        {{ $classLevel->nome_classe }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="course_id" class="form-label">Curso
                                    <span class="text-danger">*</span>
                                </label>
                                {{-- Os cursos são obtidos a partir da entidade curso --}}
                                <select name="course_id" id="course_id" class="form-select" required>
                                    <option value="" disabled @selected(!old('course_id'))>Selecione o curso</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id')==$course->id)>
                                        {{ $course->courseName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="room_id" class="form-label">Sala</label>
                                <select class="form-select" id="room_id" name="room_id">
                                    <option value="">Selecione uma sala</option>
                                    {{-- As salas são obtidas a partir da entidade Sala --}}
                                    @foreach ($rooms as $room)
                                    <option value="{{ $room->id_sala }}" @selected(old('room_id')==$room->id_sala)>
                                        {{ $room->designacao }}
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