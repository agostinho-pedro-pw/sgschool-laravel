{{-- Página que lista todas as classes escolares --}}
@extends('layouts.admin')

@section('title', 'Listar Classes - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="Lista de classes escolares">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script type="module" crossorigin src="{{ asset('dashboard/assets/dist/assets/main-ZZRh_wak.js') }}"></script>
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-BV-wpnXD.css') }}">
<link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/dist/assets/main-DVYj-QCH.css') }}">
<style>
    .dashboard-content {
        padding: 24px;
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 1px 3px #0000001a;
    }

    #classTable th,
    #classTable td {
        padding: 1rem 1.25rem;
    }

    #classTable .dropdown-menu {
        padding: .375rem;
    }

    #classTable .dropdown-item {
        border-radius: 6px;
        padding: .5rem .75rem;
        transition: background-color .15s ease, transform .15s ease;
    }

    #classTable .dropdown-menu .dropdown-item:hover,
    #classTable .dropdown-menu .dropdown-item:focus {
        background-color: #cbd5e1 !important;
        transform: translateX(3px);
    }

    #classTable .dropdown-menu .dropdown-item.text-danger:hover,
    #classTable .dropdown-menu .dropdown-item.text-danger:focus {
        background-color: #fecaca !important;
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
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Abrir ou fechar a barra lateral"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Listar Classes</h1>
                    <p class="text-muted mb-0">Gerir as classes escolares.</p>
                </div>
                <a href="{{ route('classes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>Adicionar Classe
                </a>
            </div>

            <div class="dashboard-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="classTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome da Classe</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classLevels as $classLevel)
                            <tr>
                                <td>{{ $classLevel->id_classe }}</td>
                                <td class="fw-semibold">{{ $classLevel->nome_classe }}</td>
                                <td class="text-muted">{{ $classLevel->descricao ?: '—' }}</td>
                                <td>
                                    <div class="dropdown">
                                        {{-- strategy "fixed" evita que o menu fique cortado pelo contentor da tabela
                                        --}}
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}'
                                            aria-expanded="false" aria-label="Mais opções">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('classes.show', $classLevel) }}">
                                                    <i class="bi bi-eye me-2"></i>Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('classes.edit', $classLevel) }}">
                                                    <i class="bi bi-pencil me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('classes.destroy', $classLevel) }}" method="POST"
                                                    onsubmit="return confirm('Eliminar esta classe?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-muted">Nenhuma classe encontrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('layouts._include.dashboard.footer')
</div>
@endsection