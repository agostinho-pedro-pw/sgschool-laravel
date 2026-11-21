{{-- Herda o layout principal do painel de administração --}}
@extends('layouts.admin')

@section('title', 'Adicionar Turma - sgSchool')
@section('language', 'pt-PT')

{{-- Conteúdo do

<head>: meta tags, ícone, scripts e estilos --}}
    @section('head')
    <meta name="description" content="Adicionar uma turma">
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

        /* Cartão branco que envolve o formulário */
        .dashboard-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 3px #0000001a
        }

        .dashboard-card-body {
            padding: 24px
        }
    </style>
    @endsection

    @section('content')
    <a href="#main-content" class="visually-hidden-focusable">Saltar para o conteúdo principal</a>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Barra lateral --}}
    @include('layouts._include.dashboard.sidebar')

    <div class="main-wrapper" id="mainWrapper">
        {{-- Barra superior: botão do menu e trilho de navegação --}}
        <header class="navbar top-navbar">
            <div class="container-fluid d-flex align-items-center h-100">
                <button type="button" class="hamburger-menu" id="sidebarToggle"
                    aria-label="Abrir ou fechar a barra lateral">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('turmas.index') }}">Turmas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Adicionar Turma</li>
                    </ol>
                </nav>
                <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
            </div>
        </header>

        <main class="dashboard-content" id="main-content">
            <div class="container-fluid">
                <div class="mb-4">
                    <h1 class="h3 fw-bold mb-1">Adicionar Turma</h1>
                    <p class="text-muted mb-0">Criar uma nova turma.</p>
                </div>

                {{-- Lista de erros de validação devolvidos pelo controller --}}
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
                        {{-- Envia os dados para turmas.store (POST) --}}
                        <form action="{{ route('turmas.store') }}" method="POST">
                            {{-- Token de segurança obrigatório do Laravel --}}
                            @csrf
                            <div class="row g-3">
                                {{-- Nome da turma --}}
                                <div class="col-md-6">
                                    <label for="nomeTurma" class="form-label">Nome da Turma <span
                                            class="text-danger">*</span></label>
                                    {{-- old() mantém o valor digitado se a validação falhar --}}
                                    <input type="text" class="form-control" id="nomeTurma" name="nomeTurma"
                                        value="{{ old('nomeTurma') }}" placeholder="Ex.: 10.ª A ou Turma 1" required>
                                </div>

                                {{-- Ano Letivo (2026/2027 até 2035/2036), gerado com range() --}}
                                <div class="col-md-6">
                                    <label for="anoLetivo" class="form-label">Ano Letivo <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="anoLetivo" name="anoLetivo" required>
                                        <option value="">Selecione o ano letivo</option>
                                        @foreach (array_map(fn($ano) => $ano . '/' . ($ano + 1), range(2026, 2035)) as
                                        $anoLetivo)
                                        <option value="{{ $anoLetivo }}" @selected(old('anoLetivo')===$anoLetivo)>{{
                                            $anoLetivo }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Classe --}}
                                <div class="col-md-6">
                                    <label for="classe" class="form-label">Classe <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="classe" name="classe" required>
                                        <option value="">Selecione a classe</option>
                                        @foreach (['10.ª', '11.ª', '12.ª', '13.ª classe'] as $classe)
                                        <option value="{{ $classe }}" @selected(old('classe')===$classe)>{{ $classe }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Curso (a lista $courses vem do controller) --}}
                                <div class="col-md-6">
                                    <label for="curso" class="form-label">Curso <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="curso" name="curso" required>
                                        <option value="">Selecione um curso</option>
                                        @foreach ($courses as $course)
                                        <option value="{{ $course }}" @selected(old('curso')===$course)>{{ $course }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Período (manhã selecionado por defeito) --}}
                                <div class="col-md-6">
                                    <span class="form-label d-block">Período <span class="text-danger">*</span></span>
                                    @foreach (['manhã', 'tarde', 'noite'] as $periodo)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="periodo{{ $loop->index }}"
                                            name="periodo" value="{{ $periodo }}" @checked(old('periodo', 'manhã'
                                            )===$periodo) required>
                                        <label class="form-check-label" for="periodo{{ $loop->index }}">{{
                                            ucfirst($periodo)
                                            }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Sala (Sala-01 até Sala-12) --}}
                                <div class="col-md-6">
                                    <label for="sala" class="form-label">Sala <span class="text-danger">*</span></label>
                                    <select class="form-select" id="sala" name="sala" required>
                                        <option value="">Selecione a sala</option>
                                        @foreach (array_map(fn($n) => sprintf('Sala-%02d', $n), range(1, 12)) as $sala)
                                        <option value="{{ $sala }}" @selected(old('sala')===$sala)>{{ $sala }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Botão de envio --}}
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Criar Turma</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        {{-- Rodapé --}}
        @include('layouts._include.dashboard.footer')
    </div>
    @endsection