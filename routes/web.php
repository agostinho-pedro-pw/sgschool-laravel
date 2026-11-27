<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SchoolClassController;
use App\Models\Enrollment;
use App\Http\Controllers\ClassLevelController;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// rediciona a dashboard principal
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('dashboard_sec');
/*
|--------------------------------------------------------------------------
| Autenticação e inscrição
|--------------------------------------------------------------------------
*/

Route::redirect('/register', '/enrollments/create')->name('register');


/*
|--------------------------------------------------------------------------
| Dashboards
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    /* Usado para obter o total das entidades*/
    $totalEnrollments = Enrollment::count();
    $totalDepartments = Department::count();
    $totalCourses = Course::count();

    return view('admin.dashboard.index.index', compact('totalEnrollments', 'totalDepartments', 'totalCourses'));
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Inscrições
|--------------------------------------------------------------------------
*/

Route::resource('enrollments', EnrollmentController::class);

Route::post('/enrollments/{enrollment}/accept', [EnrollmentController::class, 'accept'])
    ->name('enrollments.accept');

/*
|--------------------------------------------------------------------------
| Matrículas
|--------------------------------------------------------------------------
*/

Route::resource('registrations', RegistrationController::class);

/*
|--------------------------------------------------------------------------
| Turmas
|--------------------------------------------------------------------------
*/

Route::resource('schoolClasses', SchoolClassController::class);

/*
|--------------------------------------------------------------------------
| Anos letivos
|--------------------------------------------------------------------------
*/

Route::resource('academicYears', AcademicYearController::class);

/*
|--------------------------------------------------------------------------
| Salas (entidade independente, sem relações com outras tabelas)
|--------------------------------------------------------------------------
*/

Route::resource('rooms', RoomController::class);

/*
|--------------------------------------------------------------------------
| Classes escolares
|--------------------------------------------------------------------------
*/

Route::resource('classes', ClassLevelController::class)
    ->parameters(['classes' => 'classLevel']);

/*
|--------------------------------------------------------------------------
| Departamentos (entidade independente, sem relações com outras tabelas)
|--------------------------------------------------------------------------
*/

Route::resource('departments', DepartmentController::class)->except('show');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

/*
|--------------------------------------------------------------------------
| Matrículas nas views de estudantes existentes
|--------------------------------------------------------------------------
*/

Route::get('/all-students', [RegistrationController::class, 'index'])
    ->name('all-students');

Route::get('/add-students', [RegistrationController::class, 'create'])
    ->name('add-students');

Route::get('/edit-students/{registration}/edit', [RegistrationController::class, 'edit'])
    ->name('edit-students');

Route::get('/profile-students/{registration}', [RegistrationController::class, 'show'])
    ->name('profile-students');

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
