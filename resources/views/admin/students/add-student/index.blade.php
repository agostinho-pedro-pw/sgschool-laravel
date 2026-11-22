@extends('layouts.admin')

@section('title', 'Matrícula - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Adicionar matrícula de estudante">
<link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/dist/assets/favicon-9EIT7vLh.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    #main-content.dashboard-content {
        min-height: calc(100vh - 60px);
        padding: clamp(1rem, 2.5vw, 2rem);
        background: #f5f7fb;
    }

    #main-content .page-title {
        margin: 0 0 .5rem;
        color: #172033;
        font-size: clamp(1.5rem, 2vw, 1.9rem);
        font-weight: 700;
    }

    #main-content .dashboard-card {
        overflow: hidden;
        border: 1px solid #e5eaf1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    #main-content .dashboard-card-body {
        padding: clamp(1rem, 2.5vw, 2rem);
    }

    #registrationForm .form-label,
    #registrationForm legend.form-label {
        display: block;
        margin-bottom: .55rem;
        color: #273449;
        font-size: .98rem;
        font-weight: 600;
    }

    #registrationForm .form-control,
    #registrationForm .form-select {
        min-height: 46px;
        padding: .7rem .85rem;
        border: 1px solid #cfd8e3;
        border-radius: 8px;
    }

    #registrationForm .form-control:focus,
    #registrationForm .form-select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 .22rem rgba(37, 99, 235, .14);
    }

    #registrationForm .form-check-input:checked {
        border-color: #2563eb;
        background-color: #2563eb;
    }

    #registrationForm .btn-primary {
        min-height: 44px;
        padding: .65rem 1.15rem;
        border-color: #1d4ed8;
        border-radius: 8px;
        background: #2563eb;
        font-weight: 600;
    }

    @media (max-width: 575.98px) {
        #main-content.dashboard-content {
            padding: 1rem .75rem;
        }

        #main-content .dashboard-card-body {
            padding: 1rem;
        }

        #registrationForm .btn-primary {
            width: 100%;
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
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Abrir ou fechar o menu lateral">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('all-students') }}">Matrículas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($registration) ? 'Editar matrícula'
                        : 'Adicionar matrícula' }}</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="page-title">{{ isset($registration) ? 'Editar matrícula' : 'Adicionar matrícula' }}</h1>
                <p class="text-muted mb-0">Preencha os dados do estudante e da matrícula.</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            @php
            // Opções simples armazenadas directamente na matrícula, sem relações entre tabelas.
            $departmentOptions = [
            'informatica' => 'Informática',
            'engenharia' => 'Engenharia',
            'administracao' => 'Administração',
            'medicina' => 'Medicina',
            'psicologia' => 'Psicologia',
            ];
            $courseOptions = [
            'informatica-gestao' => 'Informática de Gestão',
            'informatica-sistemas-multimedia' => 'Informática, Sistemas e Multimédia',
            'eletronica-telecomunicacoes' => 'Eletrónica e Telecomunicações',
            'analises-clinicas' => 'Análises Clínicas',
            ];
            $classOptions = ['10.ª A', '10.ª B', '11.ª A', '12.ª A', '13.ª A'];
            $roomOptions = ['Sala-01', 'Sala-02', 'Sala-03'];
            $genderOptions = ['Masculino' => 'Homem', 'Feminino' => 'Mulher'];
            $shiftOptions = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
            $academicYearOptions = [];
            foreach (range(2026, 2035) as $year) {
            $academicYearOptions[] = $year . '/' . ($year + 1);
            }
            @endphp

            <div class="dashboard-card">
                <div class="dashboard-card-body">
                    <form id="registrationForm"
                        action="{{ isset($registration) ? route('registrations.update', $registration) : route('registrations.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($registration))
                        @method('PUT')
                        @endif

                        <div class="row gx-4 gy-3">
                            <div class="col-md-6 px-2">
                                <label for="fullName" class="form-label">Nome completo</label>
                                <input type="text" class="form-control" id="fullName" name="fullName"
                                    value="{{ old('fullName', $registration->fullName ?? '') }}"
                                    placeholder="Introduza o nome completo">
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="studentId" class="form-label">Número de estudante</label>
                                <input type="text" class="form-control" id="studentId" name="studentId"
                                    value="{{ old('studentId', $registration->studentId ?? '') }}"
                                    placeholder="Introduza o número de estudante">
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="department" class="form-label">Departamento</label>
                                <select class="form-select" id="department" name="department">
                                    <option value="">Seleccione um departamento</option>
                                    @foreach ($departmentOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('department', $registration->department
                                        ?? '') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="course" class="form-label">Curso</label>
                                <select class="form-select" id="course" name="course">
                                    <option value="">Seleccione um curso</option>
                                    @foreach ($courseOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('course', $registration->course ?? '')
                                        === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="dateOfBirth" class="form-label">Data de nascimento</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth"
                                    value="{{ old('dateOfBirth', isset($registration) && $registration->dateOfBirth ? $registration->dateOfBirth->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6 px-2">
                                <fieldset class="border-0 p-0">
                                    <legend class="form-label">Género</legend>
                                    @foreach ($genderOptions as $value => $label)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="gender-{{ $loop->index }}"
                                            name="gender" value="{{ $value }}" @checked(old('gender',
                                            $registration->gender ?? '') === $value)>
                                        <label class="form-check-label" for="gender-{{ $loop->index }}">{{ $label
                                            }}</label>
                                    </div>
                                    @endforeach
                                </fieldset>
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $registration->phone ?? '') }}"
                                    placeholder="Introduza o número de telefone">
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="parentPhone" class="form-label">Telefone do encarregado</label>
                                <input type="tel" class="form-control" id="parentPhone" name="parentPhone"
                                    value="{{ old('parentPhone', $registration->parentPhone ?? '') }}"
                                    placeholder="Introduza o telefone do encarregado">
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $registration->email ?? '') }}"
                                    placeholder="exemplo@sgschool.edu">
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="schoolClass" class="form-label">Turma</label>
                                <select class="form-select" id="schoolClass" name="schoolClass">
                                    <option value="">Seleccione uma turma</option>
                                    @foreach ($classOptions as $schoolClass)
                                    <option value="{{ $schoolClass }}" @selected(old('schoolClass', $registration->
                                        schoolClass ?? '') === $schoolClass)>{{ $schoolClass }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="academicYear" class="form-label">Ano lectivo</label>
                                <select class="form-select" id="academicYear" name="academicYear">
                                    <option value="">Seleccione o ano lectivo</option>
                                    @foreach ($academicYearOptions as $academicYear)
                                    <option value="{{ $academicYear }}" @selected(old('academicYear', $registration->
                                        academicYear ?? '') === $academicYear)>{{ $academicYear }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 px-2">
                                <label for="room" class="form-label">Sala</label>
                                <select class="form-select" id="room" name="room">
                                    <option value="">Seleccione uma sala</option>
                                    @foreach ($roomOptions as $room)
                                    <option value="{{ $room }}" @selected(old('room', $registration->room ?? '') ===
                                        $room)>{{ $room }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 px-2">
                                <fieldset class="border-0 p-0">
                                    <legend class="form-label">Turno</legend>
                                    @foreach ($shiftOptions as $value => $label)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="shift-{{ $loop->index }}"
                                            name="turno" value="{{ $value }}" @checked(old('turno', $registration->turno
                                        ?? '') === $value)>
                                        <label class="form-check-label" for="shift-{{ $loop->index }}">{{ $label
                                            }}</label>
                                    </div>
                                    @endforeach
                                </fieldset>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 px-2 d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>{{ isset($registration) ? 'Actualizar
                                    matrícula' : 'Criar matrícula' }}
                                </button>
                                <a href="{{ route('all-students') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="dashboard-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2026 sgSchool. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Feito com <i class="bi bi-heart-fill text-danger"></i> para a educação</p>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection