{{-- Formulário simples para criar uma classe escolar --}}
@extends('layouts.admin')

@section('title', 'Adicionar Classe - sgSchool')
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
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Adicionar Classe</h1>
                <p class="text-muted mb-0">Registar uma nova classe escolar.</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="class-form-card">
                <div class="class-form-card-body">
                    {{-- Envia os dados para classes.store --}}
                    <form action="{{ route('classes.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome_classe" class="form-label">Nome da Classe <span
                                        class="text-danger">*</span></span></label>
                                <input type="text" class="form-control" id="nome_classe" name="nome_classe"
                                    value="{{ old('nome_classe') }}" placeholder="Ex.: 10.ª Classe">
                            </div>

                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="4"
                                    placeholder="Descrição da classe (opcional)">{{ old('descricao') }}</textarea>
                            </div>

                            <div class="col-12 mt-3 d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2" aria-hidden="true"></i>Criar Classe
                                </button>{{--
                                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar à Lista
                                </a>--}}
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