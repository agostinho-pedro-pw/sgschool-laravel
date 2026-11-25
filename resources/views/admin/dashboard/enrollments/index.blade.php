@extends('layouts.admin')

@section('title', 'Inscrição - sgSchool')
@section('language', 'pt-PT')

@php
$editing = isset($enrollment);
@endphp

@section('head')
<meta name="description" content="sgSchool - Inscrição de estudante">
<meta name="keywords" content="educação, candidatura, matrícula, estudante">
<meta name="author" content="Agostinho Pedro">

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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

    /* Rótulos com o mesmo tamanho e sem negrito */
    #registerForm .form-label,
    #registerForm legend.form-label {
        font-size: 1.05rem;
        font-weight: 400
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
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Mostrar/ocultar menu lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="dashboard-row">
                <div class="dashboard-grid grid-cols-1">
                    <h4 class="page-title">{{ isset($enrollment) ? 'Editar inscrição' : 'Inscrição para Candidatos' }}
                    </h4>
                </div>
            </div>

            <div class="dashboard-row">
                <div class="dashboard-grid grid-cols-1">
                    <div class="dashboard-card">
                        <div class="dashboard-card-body">

                            @if (session('success'))
                            <div class="alert alert-success" role="status">{{ session('success') }}</div>
                            @endif

                            <ul class="nav nav-tabs mb-4" id="enrollmentFormTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                                        data-bs-target="#basic" type="button" role="tab" aria-controls="basic"
                                        aria-selected="true">
                                        <i class="bi bi-person-circle me-2"></i>Informações básicas
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="enrollmentFormTabContent">
                                <div class="tab-pane fade show active" id="basic" role="tabpanel"
                                    aria-labelledby="basic-tab">

                                    {{-- Criar: POST /enrollments | Editar: PUT /enrollments/{id} --}}
                                    <form id="registerForm" method="POST"
                                        action="{{ $editing ? route('enrollments.update', $enrollment) : route('enrollments.store') }}">
                                        @csrf
                                        @if ($editing)
                                        @method('PUT')
                                        @endif

                                        <div class="row gx-4 gy-3">

                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="fullName" class="form-label">Nome <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="fullName" name="fullName"
                                                        class="form-control @error('fullName') is-invalid @enderror"
                                                        value="{{ old('fullName', $enrollment->fullName ?? '') }}"
                                                        placeholder="Digite o nome completo" required>
                                                    @error('fullName')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="dateOfBirth" class="form-label">Data de nascimento <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="dateOfBirth" name="dateOfBirth"
                                                        class="form-control @error('dateOfBirth') is-invalid @enderror"
                                                        value="{{ old('dateOfBirth', $editing ? $enrollment->dateOfBirth?->format('Y-m-d') : '') }}"
                                                        required>
                                                    @error('dateOfBirth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Telefone: só números, exatamente 9 dígitos --}}
                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="phone" class="form-label">Número de telefone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="phone" name="phone"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        value="{{ old('phone', $enrollment->phone ?? '') }}"
                                                        placeholder="Digite o número de telefone" inputmode="numeric"
                                                        pattern="[0-9]{9}" maxlength="9"
                                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 9)"
                                                        required>
                                                    @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="email" class="form-label">Endereço de email</label>
                                                    <input type="email" id="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email', $enrollment->email ?? '') }}"
                                                        placeholder="exemplo@sgschool.com">
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 px-2">
                                                <fieldset class="mb-4 border-0 p-0">
                                                    <legend class="form-label">Género <span class="text-danger">*</span>
                                                    </legend>
                                                    @foreach (['Masculino', 'Feminino'] as $gender)
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gender') is-invalid @enderror"
                                                            type="radio" id="gender-{{ $loop->index }}" name="gender"
                                                            value="{{ $gender }}" @checked(old('gender',
                                                            $enrollment->gender ?? '') == $gender)>
                                                        <label class="form-check-label"
                                                            for="gender-{{ $loop->index }}">{{ $gender }}</label>
                                                    </div>
                                                    @endforeach
                                                    @error('gender')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </fieldset>
                                            </div>

                                            {{-- Cursos vêm da constante COURSES do model Enrollment --}}
                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="course" class="form-label">Curso <span
                                                            class="text-danger">*</span></label>
                                                    <select id="course" name="course"
                                                        class="form-select @error('course') is-invalid @enderror"
                                                        required>
                                                        <option value="" disabled @selected(!old('course', $enrollment->
                                                            course ?? ''))>Selecione o curso</option>
                                                        @foreach (\App\Models\Enrollment::COURSES as $value => $name)
                                                        <option value="{{ $value }}" @selected(old('course',
                                                            $enrollment->course ?? '') == $value)>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('course')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gx-4 gy-3">
                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="bi" class="form-label">BI</label>
                                                    <input class="form-control" type="file" id="bi" accept="image/*">
                                                    <div class="form-text">
                                                        Formatos aceites: PDF, PNG, JPEG (máx. 2 MB)
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 px-2">
                                                <div class="mb-4">
                                                    <label for="certificado" class="form-label">Certificado de
                                                        habilitação</label>
                                                    <input class="form-control" type="file" id="certificado"
                                                        accept="image/*">
                                                    <div class="form-text">
                                                        Formatos aceites: PDF, PNG, JPEG (máx. 2 MB)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12 px-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    {{ $editing ? 'Atualizar inscrição' : 'Submeter a inscrição' }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{--Rodapé--}}
    @include('layouts._include.dashboard.footer')
</div>
@endsection