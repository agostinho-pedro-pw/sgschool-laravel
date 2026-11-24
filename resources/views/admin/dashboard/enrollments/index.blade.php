{{-- Herda o layout principal do painel de administração --}}
@extends('layouts.admin')

@section('title', 'Inscrição - sgSchool')

@section('language', 'pt-PT')

{{-- Conteúdo do

<head>: meta tags, ícone, scripts e estilos --}}
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

        /* Barra lateral fixa à esquerda */
        .sidebar {
            z-index: 1040;
            background: #1f2937;
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0
        }

        /* Área principal: deixa espaço para a barra lateral */
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

        /* Rótulos de todos os campos com o mesmo tamanho (um pouco maior), sem negrito */
        #registerForm .form-label,
        #registerForm legend.form-label {
            font-size: 1.05rem;
            font-weight: 400
        }
    </style>
    @endsection

    @section('content')
    {{-- Formulário para submeter uma candidatura --}}
    <a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
    <div class="search-backdrop" id="searchBackdrop"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Barra lateral --}}
    @include('layouts._include.dashboard.sidebar')

    <div class="main-wrapper" id="mainWrapper">
        {{-- Barra superior: botão do menu e trilho de navegação --}}
        <header class="navbar top-navbar">
            <div class="container-fluid d-flex align-items-center h-100">
                <button type="button" class="hamburger-menu" id="sidebarToggle"
                    aria-label="Mostrar/ocultar menu lateral" aria-controls="sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="Trilho de navegação" class="d-none d-lg-block ms-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inscrição de estudante</li>
                    </ol>
                </nav>
                <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
            </div>
        </header>

        <main class="dashboard-content" id="main-content">
            <div class="container-fluid">
                <div class="dashboard-row">
                    <div class="dashboard-grid grid-cols-1">
                        {{-- O título muda conforme estamos a criar ou a editar ($enrollment só existe ao editar) --}}
                        <h4 class="page-title">{{ isset($enrollment) ? 'Editar inscrição' : 'Inscrição de estudante' }}
                        </h4>
                        <p class="text-muted">Preencha os campos abaixo para {{ isset($enrollment) ? 'atualizar a
                            inscrição'
                            : 'submeter a sua candidatura' }}.</p>
                    </div>
                </div>

                <div class="dashboard-row">
                    <div class="dashboard-grid grid-cols-1">
                        <div class="dashboard-card">
                            <div class="dashboard-card-body">
                                {{--Alerta Bootstrap , com a mensagem de sucess--}}
                                @if (session('success'))
                                <div class="alert alert-success" role="status">
                                    {{ session('success') }}
                                </div>
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
                                        {{-- O mesmo formulário serve para criar (POST /enrollments) e editar (PUT
                                        /enrollments/{id}) --}}
                                        <form id="registerForm"
                                            action="{{ isset($enrollment) ? route('enrollments.update', $enrollment) : route('enrollments.store') }}"
                                            method="POST">
                                            {{-- Token de segurança obrigatório do Laravel --}}
                                            @csrf
                                            {{-- Formulários HTML só enviam GET/POST, por isso simulamos o PUT ao editar
                                            --}}
                                            @if (isset($enrollment))
                                            @method('PUT')
                                            @endif
                                            <div class="row gx-4 gy-3">
                                                {{-- Nome completo --}}
                                                <div class="col-md-6 px-2">
                                                    <div class="mb-4">
                                                        <label for="fullName" class="form-label">Nome <span
                                                                class="text-danger">*</span></label>
                                                        {{-- old() mantém o valor digitado se a validação falhar; ao
                                                        editar usa o valor da BD --}}
                                                        <input type="text" class="form-control" id="fullName"
                                                            name="fullName"
                                                            value="{{ old('fullName', $enrollment->fullName ?? '') }}"
                                                            placeholder="Introduza o nome completo">
                                                    </div>
                                                </div>

                                                {{-- Data de nascimento (formatada como Y-m-d para o input type="date")
                                                --}}
                                                <div class="col-md-6 px-2">
                                                    <div class="mb-4">
                                                        <label for="dateOfBirth" class="form-label">Data de
                                                            nascimento <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="dateOfBirth"
                                                            name="dateOfBirth"
                                                            value="{{ old('dateOfBirth', isset($enrollment) ? $enrollment->dateOfBirth->format('Y-m-d') : '') }}">
                                                    </div>
                                                </div>

                                                {{-- Telefone: obrigatório, só números e exatamente 9 dígitos --}}
                                                <div class="col-md-6 px-2">
                                                    <div class="mb-4">
                                                        <label for="phone" class="form-label">Número de telefone
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" class="form-control" id="phone"
                                                            name="phone"
                                                            value="{{ old('phone', $enrollment->phone ?? '') }}"
                                                            placeholder="Introduza o número de telefone" min="100000000"
                                                            max="999999999" {{--usado para não termos letras nem campo
                                                            telefone--}}
                                                            oninput="if (this.value.length > 9) this.value = this.value.slice(0, 9);"
                                                            required>
                                                    </div>
                                                </div>

                                                {{-- Email --}}
                                                <div class="col-md-6 px-2">
                                                    <div class="mb-4">
                                                        <label for="email" class="form-label">Endereço de email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="email" name="email"
                                                            value="{{ old('email', $enrollment->email ?? '') }}"
                                                            placeholder="exemplo@sgschool.edu">
                                                    </div>
                                                </div>

                                                {{-- Género: botões de opção gerados a partir da lista --}}
                                                <div class="col-md-6 px-2">
                                                    <fieldset class="mb-4 border-0 p-0">
                                                        <legend class="form-label">Género <span
                                                                class="text-danger">*</span>
                                                        </legend>
                                                        @foreach (['Masculino', 'Feminino'] as $gender)
                                                        <div class="form-check">
                                                            {{-- @checked marca a opção guardada ou a escolhida antes do
                                                            erro --}}
                                                            <input class="form-check-input" type="radio"
                                                                id="gender-{{ $loop->index }}" name="gender"
                                                                value="{{ $gender }}" @checked(old('gender',
                                                                $enrollment->gender ?? '') == $gender)
                                                            >

                                                            <label class="form-check-label"
                                                                for="gender-{{ $loop->index }}">
                                                                {{ $gender }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </fieldset>
                                                </div>

                                                {{-- Curso: lista vinda da constante COURSES do model Enrollment --}}
                                                <div class="col-md-6 px-2">
                                                    <div class="mb-4">
                                                        <label for="course" class="form-label">Curso <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select" id="course" name="course">
                                                            <!--Usei para deixar o codigo mais automatico ao inserir os cursos-->

                                                            @foreach (\App\Models\Enrollment::COURSES as $value =>
                                                            $name)
                                                            <option value="{{ $value }}" @selected(old('course',
                                                                $enrollment->course ?? '') == $value)>
                                                                {{ $name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Botão de envio: o texto muda conforme criar ou editar --}}
                                            <div class="row mt-4">
                                                <div class="col-12 px-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-check-circle me-2"></i>
                                                        {{ isset($enrollment) ? 'Atualizar inscrição' : 'Enviar a
                                                        inscrição'
                                                        }}
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

        {{-- Rodapé --}}
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