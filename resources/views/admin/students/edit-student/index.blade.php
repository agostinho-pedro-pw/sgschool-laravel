@extends('layouts.admin')

@section('title', 'Editar matrícula - sgSchool')

@section('content')
    @include('layouts._include.dashboard.sidebar')

    <div class="main-wrapper" id="mainWrapper">
        <header class="navbar top-navbar">
            <div class="container-fluid">
                <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Abrir ou fechar a barra lateral">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="Navegação estrutural" class="ms-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('all-students') }}">Matrículas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </header>

        <main class="dashboard-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 fw-bold mb-1">Editar matrícula</h1>
                        <p class="text-muted mb-0">{{ $enrollment->fullName }}</p>
                    </div>
                    <a href="{{ route('all-students') }}" class="btn btn-outline-secondary">Listar matrículas</a>
                </div>

                <div class="dashboard-card">
                    <div class="dashboard-card-body">
                        <form action="{{ route('enrollments.update', $enrollment) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullName" class="form-label">Nome completo</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName"
                                        value="{{ old('fullName', $enrollment->fullName) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="dateOfBirth" class="form-label">Data de nascimento</label>
                                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth"
                                        value="{{ old('dateOfBirth', $enrollment->dateOfBirth?->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $enrollment->phone) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $enrollment->email) }}">
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="border-0 p-0">
                                        <legend class="form-label">Género</legend>
                                        @foreach (['Masculino', 'Feminino', 'Outro'] as $gender)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="gender-{{ $loop->index }}"
                                                    name="gender" value="{{ $gender }}"
                                                    @checked(old('gender', $enrollment->gender) === $gender)>
                                                <label class="form-check-label" for="gender-{{ $loop->index }}">
                                                    {{ $gender }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="course" class="form-label">Curso</label>
                                    <select class="form-select" id="course" name="course">
                                        <option value="">Selecione um curso</option>
                                        @foreach (\App\Models\Enrollment::COURSES as $value => $name)
                                            <option value="{{ $value }}" @selected(old('course', $enrollment->course) === $value)>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="schoolClass" class="form-label">Classe/Turma</label>
                                    <select class="form-select" id="schoolClass" name="schoolClass">
                                        <option value="">Selecione uma turma</option>
                                        @foreach (\App\Models\Enrollment::CLASSES as $schoolClass)
                                            <option value="{{ $schoolClass }}"
                                                @selected(old('schoolClass', $enrollment->schoolClass) === $schoolClass)>
                                                {{ $schoolClass }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="room" class="form-label">Sala</label>
                                    <select class="form-select" id="room" name="room">
                                        <option value="">Selecione uma sala</option>
                                        @foreach (\App\Models\Enrollment::ROOMS as $room)
                                            <option value="{{ $room }}" @selected(old('room', $enrollment->room) === $room)>
                                                {{ $room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <fieldset class="border-0 p-0">
                                        <legend class="form-label">Período</legend>
                                        @foreach (\App\Models\Enrollment::PERIODS as $value => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="period-{{ $loop->index }}" name="period" value="{{ $value }}"
                                                    @checked(old('period', $enrollment->period) === $value)>
                                                <label class="form-check-label" for="period-{{ $loop->index }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </fieldset>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Guardar alterações</button>
                            <a href="{{ route('all-students') }}" class="btn btn-outline-secondary mt-3">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
