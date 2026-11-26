@extends('layouts.admin')

@section('title', 'Editar Inscrição - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Editar uma inscrição de candidato">
<meta name="keywords" content="educação, candidatura, matrícula, estudante">
<meta name="author" content="Agostinho Pedro">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    .dashboard-content {
        padding: 24px;
    }

    #registerForm .form-label,
    #registerForm legend.form-label {
        font-size: 1.05rem;
        font-weight: 400;
    }

    #registerForm .form-control,
    #registerForm .form-select {
        min-height: 44px;
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
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Mostrar ou ocultar menu lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Editar inscrição</h1>
                <p class="text-muted mb-0">Atualize os dados do candidato abaixo.</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="dashboard-card">
                <div class="dashboard-card-body p-4">
                    <h2 class="h5 mb-4">
                        <i class="bi bi-person-circle me-2" aria-hidden="true"></i>Informações do candidato
                    </h2>

                    {{-- Envia os dados para enrollments.update (PUT). --}}
                    <form id="registerForm" method="POST" action="{{ route('enrollments.update', $enrollment) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row gx-4 gy-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Nome</label>
                                <input type="text" id="fullName" name="fullName" class="form-control"
                                    value="{{ old('fullName', $enrollment->fullName ?? '') }}"
                                    placeholder="Digite o nome completo">
                            </div>

                            <div class="col-md-6">
                                <label for="dateOfBirth" class="form-label">Data de nascimento</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control"
                                    value="{{ old('dateOfBirth', isset($enrollment) ? $enrollment->dateOfBirth?->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Número de telefone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('phone', $enrollment->phone ?? '') }}"
                                    placeholder="Digite o número de telefone" inputmode="numeric">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Endereço de email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email', $enrollment->email ?? '') }}"
                                    placeholder="exemplo@sgschool.com">
                            </div>

                            <div class="col-md-6">
                                <fieldset class="mb-2 border-0 p-0">
                                    <legend class="form-label">Género</legend>
                                    @foreach (['Masculino', 'Feminino'] as $gender)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="gender-{{ $loop->index }}"
                                            name="gender" value="{{ $gender }}" @checked(old('gender',
                                            $enrollment->gender ?? '') === $gender)>
                                        <label class="form-check-label" for="gender-{{ $loop->index }}">
                                            {{ $gender }}
                                        </label>
                                    </div>
                                    @endforeach
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <label for="course" class="form-label">Curso</label>
                                <select id="course" name="course" class="form-select">
                                    <option value="">Selecione o curso</option>
                                    @foreach (\App\Models\Enrollment::COURSES as $value => $name)
                                    <option value="{{ $value }}" @selected(old('course', $enrollment->course ?? '') ==
                                        $value)>
                                        {{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="bi" class="form-label">Bilhete de Identidade</label>
                                <input class="form-control" type="file" id="bi" name="bi" accept=".pdf,.png,.jpg,.jpeg">
                                <div class="form-text">PDF, PNG ou JPEG (máx. 2 MB).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="certificado" class="form-label">Certificado de habilitação</label>
                                <input class="form-control" type="file" id="certificado" name="certificado"
                                    accept=".pdf,.png,.jpg,.jpeg">
                                <div class="form-text">PDF, PNG ou JPEG (máx. 2 MB).</div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2" aria-hidden="true"></i>Atualizar inscrição
                            </button>
                            <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar à lista
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection