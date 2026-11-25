{{-- Página: Detalhes de uma candidatura de matrícula (herda o layout do painel admin) --}}
@extends('layouts.admin')

@section('title', 'Detalhes da Candidatura')

@section('language', 'pt-PT')

{{-- Cabeçalho do HTML: meta tags, favicon, assets compilados e estilos da página --}}
@section('head')
<meta name="description" content="sgSchool - Detalhes da candidatura de matrícula">
<meta name="keywords" content="educação, candidatura, matrícula, estudante">
<meta name="author" content="Agostinho Pedro">

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">

{{-- Só o espaçamento do conteúdo; o resto (sidebar, body, navbar) já vem dos CSS compilados --}}
<style>
    .dashboard-content {
        padding: 24px;
    }

    @media (max-width: 575.98px) {
        .dashboard-content {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')

{{-- Acessibilidade: saltar para o conteúdo principal --}}
<a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>

{{-- Elementos exigidos pelo script do painel (pesquisa e sidebar) --}}
<div class="search-backdrop" id="searchBackdrop"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Barra lateral --}}
@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    {{-- Cabeçalho superior: menu hambúrguer + breadcrumb --}}
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Alternar barra lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>

            <nav aria-label="Navegação estrutural do cabeçalho" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('enrollments.index') }}">Inscrições</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes da Candidatura</li>
                </ol>
            </nav>

            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    {{-- Conteúdo principal --}}
    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            {{-- Título da página e botões (Editar / Voltar) --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Detalhes da Candidatura</h1>
                    <p class="text-muted mb-0">Informações submetidas pelo candidato.</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('enrollments.edit', $enrollment) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar às candidaturas
                    </a>
                </div>
            </div>

            {{-- Cartão com os dados do candidato --}}
            <div class="dashboard-card">
                <div class="dashboard-card-header py-4 px-4">
                    <h2 class="h5 mb-0">{{ $enrollment->fullName }}</h2>
                </div>

                <div class="dashboard-card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Género</span>
                            <span class="fw-semibold">{{ $enrollment->gender ?? 'Não indicado' }}</span>
                        </div>

                        {{-- Data de nascimento: "?->" evita erro se o campo estiver vazio --}}
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Data de nascimento</span>
                            <span class="fw-semibold">
                                {{ $enrollment->dateOfBirth?->format('d/m/Y') ?? 'Não indicado' }}
                            </span>
                        </div>

                        {{-- Curso: converte o código guardado no nome legível (Enrollment::COURSES) --}}
                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Curso pretendido</span>
                            <span class="fw-semibold">
                                {{ \App\Models\Enrollment::COURSES[$enrollment->course] ?? $enrollment->course }}
                            </span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Data da candidatura</span>
                            <span class="fw-semibold">{{ $enrollment->applicationDate->format('d/m/Y') }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Telefone</span>
                            <span class="fw-semibold">{{ $enrollment->phone }}</span>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <span class="small text-muted d-block">Email</span>
                            <span class="fw-semibold">{{ $enrollment->email }}</span>
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
                    <p class="mb-0">Criado com <i class="bi bi-heart-fill text-danger"></i> para a educação</p>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection