@extends('layouts.admin')

@section('title', 'List Courses - sgSchool')
@section('language', 'pt-PT')

@section('head')
<meta name="description" content="List of courses">
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
</style>
@endsection

@section('content')
<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>
<div class="search-backdrop" id="searchBackdrop"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('layouts._include.dashboard.sidebar')

<div class="main-wrapper" id="mainWrapper">
    <header class="navbar top-navbar">
        <div class="container-fluid d-flex align-items-center h-100">
            <button type="button" class="hamburger-menu" id="sidebarToggle" aria-label="Toggle sidebar"
                aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="Breadcrumb" class="d-none d-lg-block ms-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Courses</li>
                </ol>
            </nav>
            <div class="navbar-brand d-lg-none fw-bold me-auto">sgSchool</div>
        </div>
    </header>

    <main class="dashboard-content" id="main-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">List Courses</h1>
                    <p class="text-muted mb-0">Manage the courses in your institution.</p>
                </div>
                <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
            </div>

            <div class="mb-3">
                <label for="courseSearch" class="visually-hidden">Search courses</label>
                <input type="search" class="form-control" id="courseSearch" placeholder="Search courses...">
            </div>

            <div class="dashboard-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="courseTable">
                        <thead>
                            <tr>
                                <th scope="col">Course Code</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td class="fw-semibold">{{ $course->courseCode }}</td>
                                    <td>{{ $course->courseName }}</td>
                                    <td>{{ $course->department }}</td>
                                    <td>
                                        <div class="d-flex gap-2 text-nowrap">
                                            <a href="{{ route('courses.show', $course) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                            <a href="{{ route('courses.edit', $course) }}"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                                onsubmit="return confirm('Delete this course?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-muted">No courses found.</td>
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

<script>
    document.getElementById('courseSearch').addEventListener('input', function () {
        const searchText = this.value.toLowerCase();

        document.querySelectorAll('#courseTable tbody tr').forEach(function (row) {
            row.hidden = !row.textContent.toLowerCase().includes(searchText);
        });
    });
</script>
@endsection
