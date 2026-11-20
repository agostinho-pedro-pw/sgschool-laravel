@extends('layouts.admin')

@section('title', 'Adicionar Curso - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Adicionar um curso">
<link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/dist/assets/favicon-9EIT7vLh.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif
    }

    .sidebar {
        z-index: 1040;
        background: #1f2937;
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0
    }

    .main-wrapper {
        min-height: 100vh;
        margin-left: 260px;
        transition: margin-left .3s
    }

    .top-navbar {
        background: #fff;
        height: 60px;
        padding: 0 1rem;
        box-shadow: 0 1px 3px #0000001a
    }

    .dashboard-content {
        padding: 24px
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 1px 3px #0000001a
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
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Cursos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Adicionar Curso</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Adicionar Curso</h1>
                <p class="text-muted mb-0">Criar um novo curso.</p>
            </div>
            {{--Alertas da para a view--}}
            @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

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
                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="courseCode" class="form-label">Código do Curso</label>
                                <input type="text" class="form-control" id="courseCode" name="courseCode"
                                    value="{{ old('courseCode') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="courseName" class="form-label">Nome do Curso</label>
                                <input type="text" class="form-control" id="courseName" name="courseName"
                                    value="{{ old('courseName') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="department" class="form-label">Departamento</label>
                                {{-- Todos os departamentos listados --}}
                                <select class="form-select" id="department" name="department" required>
                                    <option value="">Selecione um departamento</option>
                                    <option value="Ciência da Computação">Ciência da Computação</option>
                                    <option value="Engenharia Informática">Engenharia Informática</option>
                                    <option value="Sistemas de Informação">Sistemas de Informação</option>
                                    <option value="Redes de Computadores">Redes de Computadores</option>
                                    <option value="Engenharia de Software">Engenharia de Software</option>
                                    <option value="Multimédia">Multimédia</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="courseDescription" class="form-label">Descrição do Curso</label>
                                <textarea class="form-control" id="courseDescription" name="courseDescription"
                                    rows="4">{{ old('courseDescription') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Criar Curso</button>
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