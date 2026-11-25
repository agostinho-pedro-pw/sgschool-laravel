{{-- Formulário para criar um departamento --}}
@extends('layouts.admin')

@section('title', 'Adicionar Departamento - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Adicionar um departamento">
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
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle"
                aria-label="Abrir ou fechar a barra lateral">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Navegação estrutural" class="d-none d-lg-block ms-3">
            </nav>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Adicionar Departamento</h1>
                <p class="text-muted mb-0">Criar um novo departamento.</p>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-body">
                    {{-- Envia os dados para departments.store (POST) --}}
                    <form action="{{ route('departments.store') }}" method="POST">
                        {{-- Token de segurança obrigatório do Laravel --}}
                        @csrf
                        <div class="row g-3">
                            {{-- Nome do departamento --}}
                            <div class="col-md-6">
                                <label for="department_name" class="form-label">Nome do Departamento <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="department_name" name="department_name"
                                    value="{{ old('department_name') }}" placeholder="Ex.: Ciências Informáticas">
                            </div>

                            {{-- Código curto do departamento --}}
                            <div class="col-md-6">
                                <label for="department_code" class="form-label">Código <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="department_code" name="department_code"
                                    value="{{ old('department_code') }}" placeholder="Ex.: CI">
                            </div>

                            {{-- Descrição do departamento --}}
                            <div class="col-12">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Breve descrição do departamento">{{ old('description') }}</textarea>
                            </div>

                            {{-- Botões de ação --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Criar Departamento</button>{{--
                                botão de cancelar
                                <a href="{{ route('departments.index') }}" class="btn btn-light">Cancelar</a>--}}
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