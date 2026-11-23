@extends('layouts.admin')

@section('title', 'Perfil do estudante - Painel sgSchool')

@section('language', 'pt-PT')

@section('head')
<meta name="description" content="sgSchool - Plataforma moderna de gestão escolar">
<meta name="keywords" content="educação, painel, escola, gestão, administração">
<meta name="author" content="Agostinho Pedro">

<!-- Ligação prévia aos domínios externos -->
<link rel="preconnect" href="https://ui-avatars.com" crossorigin>

<!-- Ícone do separador -->
<link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/dist/assets/favicon-9EIT7vLh.ico') }}">

<!-- Scripts e estilos do painel -->
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
</style>
@endsection

@section('content')

@php
// Nomes legíveis dos cursos e turnos (os mesmos da lista de matrículas)
$courseLabels = [
'informatica-gestao' => 'Informática de Gestão',
'informatica-sistemas-multimedia' => 'Informática, Sistemas e Multimédia',
'eletronica-telecomunicacoes' => 'Eletrónica e Telecomunicações',
'analises-clinicas' => 'Análises Clínicas',
];
$shiftLabels = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
@endphp

<!-- Ligação para saltar ao conteúdo principal (acessibilidade) -->
<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>

<!-- Elementos necessários para o JavaScript do painel -->
<div class="search-backdrop" id="searchBackdrop"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Barra lateral -->
@include('layouts._include.dashboard.sidebar')

<!-- Área principal -->
<div class="main-wrapper" id="mainWrapper">
    <!-- Cabeçalho -->
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <!-- Botão do menu -->
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Mostrar/ocultar menu lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Trilho de navegação (ecrã grande) -->
            <nav aria-label="Trilho de navegação" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item active">Perfil do estudante</li>
                </ol>
            </nav>

            <!-- Logótipo (telemóvel) -->
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>

            <div class="flex-grow-1 d-none d-lg-block"></div>

            <!-- Ações do lado direito -->
            <div class="d-flex align-items-center gap-2">
                <!-- Pesquisa -->
                <div class="search-container">
                    <button type="button" class="btn btn-light btn-icon" id="searchToggle" aria-label="Abrir pesquisa"
                        aria-controls="searchForm">
                        <i class="bi bi-search"></i>
                    </button>

                    <div class="search-form" id="searchForm" role="search" aria-label="Pesquisa no site">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" id="searchInput" aria-label="Pesquisar páginas"
                            placeholder="Pesquisar..." data-bs-toggle="dropdown">
                        <button type="button" class="close-search" id="closeSearch" aria-label="Fechar pesquisa">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <ul class="dropdown-menu w-100 mt-2">
                            <li><a class="dropdown-item" href="#">Registo de estudantes</a></li>
                            <li><a class="dropdown-item" href="#">Gestão de cursos</a></li>
                            <li><a class="dropdown-item" href="#">Submissão de notas</a></li>
                            <li><a class="dropdown-item" href="#">Diretório de professores</a></li>
                            <li><a class="dropdown-item" href="#">Recursos da biblioteca</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Pesquisa avançada</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Notificações -->
                <div class="dropdown">
                    <button type="button" class="btn btn-light btn-icon position-relative" data-bs-toggle="dropdown"
                        id="notificationsToggle" aria-label="Notificações">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem;">3</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 320px;">
                        <li class="dropdown-header d-flex align-items-center justify-content-between">
                            <span>Notificações</span>
                            <small class="text-muted">3 novas</small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-calendar-check text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">Novo evento</div>
                                        <div class="text-muted small">Feira de ciências a 15 de março</div>
                                        <div class="text-muted small">Há 5 minutos</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">Trabalho submetido</div>
                                        <div class="text-muted small">John entregou o seu trabalho</div>
                                        <div class="text-muted small">Há 2 horas</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-exclamation-triangle text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">Alerta do sistema</div>
                                        <div class="text-muted small">Cópia de segurança da base de dados concluída
                                        </div>
                                        <div class="text-muted small">Ontem</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-center" href="notifications.html">
                                <small>Ver todas as notificações</small>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Ações rápidas -->
                <div class="dropdown">
                    <button type="button" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                        aria-label="Ações rápidas">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="add-student.html"><i
                                    class="bi bi-person-plus me-2"></i>Adicionar Estudante</a></li>
                        <li><a class="dropdown-item" href="add-course.html"><i class="bi bi-book me-2"></i>Adicionar
                                Curso</a></li>
                        <li><a class="dropdown-item" href="add-professor.html"><i
                                    class="bi bi-person-badge me-2"></i>Adicionar professor</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-plus me-2"></i>Agendar evento</a>
                        </li>
                    </ul>
                </div>

                <!-- Menu do utilizador -->
                <div class="dropdown">
                    <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="dropdown"
                        aria-label="Menu da conta de Sarah Johnson">
                        <span class="user-avatar me-2">
                            SJ
                        </span>
                        <span class="d-none d-md-inline">Sarah Johnson</span>
                        <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-question-circle me-2"></i>Centro de
                                ajuda</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Terminar
                                sessão</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <!-- Cabeçalho do perfil: dados reais do estudante -->
            <div class="dashboard-row">
                <div class="dashboard-grid grid-cols-1">
                    <div class="dashboard-card">
                        <div class="dashboard-card-body">
                            <div class="row align-items-center">
                                <div class="col-md-auto text-center text-md-start mb-3 mb-md-0 pe-md-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($registration->fullName) }}&background=6366f1&color=fff&size=120"
                                        alt="{{ $registration->fullName }}" class="rounded-circle" width="120"
                                        height="120" loading="lazy">
                                </div>
                                <div class="col-md ms-md-2">
                                    <h3 class="mb-1">{{ $registration->fullName }}</h3>
                                    <p class="text-muted mb-2">{{ $courseLabels[$registration->course] ??
                                        $registration->course }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary"><i class="bi bi-hash me-1"></i>{{
                                            $registration->studentId }}</span>
                                        <span class="badge bg-info text-dark"><i class="bi bi-people me-1"></i>{{
                                            $registration->schoolClass }}</span>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-calendar me-1"></i>{{
                                            $registration->academicYear }}</span>
                                    </div>
                                </div>
                                <div class="col-md-auto mt-3 mt-md-0 ms-md-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('registrations.edit', $registration) }}"
                                            class="btn btn-outline-primary">
                                            <i class="bi bi-pencil me-2"></i>Editar perfil
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary">
                                            <i class="bi bi-download me-2"></i>Transferir relatório
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separadores com os detalhes do perfil -->
            <div class="dashboard-row">
                <div class="dashboard-grid grid-cols-1">
                    <div class="dashboard-card">
                        <div class="dashboard-card-body">
                            <!-- Navegação dos separadores -->
                            <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                        data-bs-target="#overview" type="button" role="tab">
                                        <i class="bi bi-person me-2"></i>Visão geral
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="courses-tab" data-bs-toggle="tab"
                                        data-bs-target="#courses" type="button" role="tab">
                                        <i class="bi bi-book me-2"></i>Cursos
                                    </button>
                                </li>
                            </ul>

                            <!-- Conteúdo dos separadores -->
                            <div class="tab-content" id="profileTabContent">
                                <!-- Separador: Visão geral (dados reais do estudante) -->
                                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="mb-3">Informações pessoais</h5>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-muted">Nome completo:</td>
                                                        <td>{{ $registration->fullName }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">N.º de estudante:</td>
                                                        <td>{{ $registration->studentId }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Data de nascimento:</td>
                                                        <td>{{ $registration->dateOfBirth ?
                                                            \Carbon\Carbon::parse($registration->dateOfBirth)->format('d/m/Y')
                                                            : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Género:</td>
                                                        <td>{{ $registration->gender }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">E-mail:</td>
                                                        <td>{{ $registration->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Telefone:</td>
                                                        <td>{{ $registration->phone }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="mb-3">Informações académicas</h5>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-muted">Curso:</td>
                                                        <td>{{ $courseLabels[$registration->course] ??
                                                            $registration->course }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Turma:</td>
                                                        <td>{{ $registration->schoolClass }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Ano letivo:</td>
                                                        <td>{{ $registration->academicYear }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Sala:</td>
                                                        <td>{{ $registration->room }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Turno:</td>
                                                        <td>{{ $shiftLabels[$registration->turno] ??
                                                            $registration->turno }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Rodapé -->
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