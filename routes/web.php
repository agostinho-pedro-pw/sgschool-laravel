<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota inicial: redireciona para o dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/

Route::redirect('/register', '/enrollments/create')->name('register');

Route::post('/create-user', function (Request $request) {
    try {
        User::create([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return redirect()->route('dashboard');
    } catch (Exception $e) {
        return back()->withInput();
    }
})->name('create-user');

/*
|--------------------------------------------------------------------------
| Dashboards
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('admin.dashboard.index.index');
})->name('dashboard');

Route::get('/dashboard-1', function () {
    return view('admin.dashboard.index-1.index');
})->name('dashboard-1');

Route::get('/dashboard-2', function () {
    return view('admin.dashboard.index-2.index');
})->name('dashboard-2');

Route::get('/widgets', function () {
    return view('admin.dashboard.widgets.index');
})->name('widgets');

Route::get('/analytics', function () {
    return view('admin.dashboard.analytics.index');
})->name('analytics');

Route::resource('enrollments', EnrollmentController::class);

Route::post('/enrollments/{enrollment}/accept', [EnrollmentController::class, 'accept'])
    ->name('enrollments.accept');

/*
|--------------------------------------------------------------------------
| Eventos
|--------------------------------------------------------------------------
*/

Route::get('/events', function () {
    return view('admin.auth.events.index');
})->name('eventos');

/*
|--------------------------------------------------------------------------
| Professores
|--------------------------------------------------------------------------
*/

Route::get('/all-professors', function () {
    return view('admin.professors.all-professors.index');
})->name('all-professors');

Route::get('/add-professors', function () {
    return view('admin.professors.add-professor.index');
})->name('add-professors');

Route::get('/edit-professors', function () {
    return view('admin.professors.edit-professor.index');
})->name('edit-professors');

Route::get('/profile-professors', function () {
    return view('admin.professors.professor-profile.index');
})->name('profile-professors');

/*
|--------------------------------------------------------------------------
| Estudantes
|--------------------------------------------------------------------------
*/

Route::get('/all-students', function () {
    return view('admin.students.all-students.index');
})->name('all-students');

Route::get('/add-students', function () {
    return view('admin.students.add-student.index');
})->name('add-students');

Route::get('/edit-students', function () {
    return view('admin.students.edit-student.index');
})->name('edit-students');

Route::get('/profile-students', function () {
    return view('admin.students.student-profile.index');
})->name('profile-students');

/*
|--------------------------------------------------------------------------
| Cursos
|--------------------------------------------------------------------------
*/

Route::resource('courses', CourseController::class);

Route::redirect('/all-course', '/courses')->name('all-course');
Route::redirect('/add-courses', '/courses/create')->name('add-courses');
Route::redirect('/edit-course', '/courses')->name('edit-course');
Route::redirect('/course-info', '/courses')->name('course-info');

Route::get('/course-payment', function () {
    return view('admin.courses.course-payment.index');
})->name('course-payment');

/*
|--------------------------------------------------------------------------
| Correio
|--------------------------------------------------------------------------
*/

Route::get('/mailbox-compose', function () {
    return view('admin.mailbox.mailbox-compose.index');
})->name('mailbox-compose');

Route::get('/mailbox-view', function () {
    return view('admin.mailbox.mailbox-view.index');
})->name('mailbox-view');

Route::get('/mailbox', function () {
    return view('admin.mailbox.mailbox.index');
})->name('mailbox');

/*
|--------------------------------------------------------------------------
| Departamento
|--------------------------------------------------------------------------
*/

Route::get('/add-department', function () {
    return view('admin.departments.add-department.index');
})->name('add-department');

Route::get('/edit-department', function () {
    return view('admin.departments.edit-department.index');
})->name('edit-department');

Route::get('/department', function () {
    return view('admin.departments.departments.index');
})->name('department');
