<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ReportController;

// Public routes
Route::get('/', [AuthController::class, "login"]); 
Route::post('/login', [AuthController::class, "authlogin"]);
Route::get('/logout', [AuthController::class, "logout"]);

// Admin routes
Route::middleware(['auth', 'Admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, "dashboard"]);

    // Admin management
    Route::prefix('admin')->group(function () {
        Route::get('list', [AdminController::class, "list"]);
        Route::get('add', [AdminController::class, "add"]);
        Route::post('add', [AdminController::class, "Addadmin"]);
        Route::get('edit/{id}', [AdminController::class, "edit"]);
        Route::put('edit/{id}', [AdminController::class, "update"]);
        Route::get('delete/{id}', [AdminController::class, "delete"]);
    });

    // Student management
    Route::prefix('student')->group(function () {
        Route::get('list', [StudentController::class, "list"])->name('student.list');
        Route::get('add', [StudentController::class, "add"])->name('student.add');
        Route::post('add', [StudentController::class, "store"])->name('student.store');
        Route::get('edit/{id}', [StudentController::class, "edit"])->name('student.edit');
        Route::put('edit/{id}', [StudentController::class, "update"])->name('student.update');
        Route::get('delete/{id}', [StudentController::class, "delete"])->name('student.delete');
    });

    // Subjects and Marks
    Route::resource('subjects', SubjectController::class);
    Route::resource('marks', MarksController::class);
    Route::get('/marks/{classId}/students', [MarksController::class, 'getStudents']);
    Route::get('/marks/{classId}/subjects', [MarksController::class, 'getSubjects']);

    // Reports
});

Route::get('/students/{student}/report', [ReportController::class, 'studentReport'])
    ->name('students.report');
   
    // Route::get('/student/report', [ReportController::class, 'studentSelfReport'])
    // ->name('student.report') ->middleware('auth');
    
Route::middleware(['auth', 'Student'])->group(function () {
    Route::get('student/dashboard', [DashboardController::class, "dashboard"]);

});