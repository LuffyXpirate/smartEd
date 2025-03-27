<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FrontendController;

// Route::get('/', [FrontendController::class, 'index']);
// Route::get('/frontendpage', [FrontendController::class, 'index']);

// Uncomment or modify the following routes if needed:
Route::get('/', [AuthController::class, "login"]); 
Route::post('/login', [AuthController::class, "authlogin"]);
Route::get('/logout', [AuthController::class, "logout"]);


Route::middleware(['Admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, "dashboard"]);

    Route::get('admin/list', [AdminController::class, "list"]);
    Route::get('admin/add', [AdminController::class, "add"]);
    Route::post('admin/add', [AdminController::class, "Addadmin"]);
    Route::get('admin/edit/{id}', [AdminController::class, "edit"]);
    Route::put('admin/edit/{id}', [AdminController::class, "update"]);
    Route::get('admin/delete/{id}', [AdminController::class, "delete"]);

    // Route::get('admin/student/report/{student}', [ReportController::class, 'generateReport'])->name('student.report');

    // Manage students
    // List all students
    Route::get('student/list', [StudentController::class, "list"])->name('student.list');
    // Show the form to add a new student
    Route::get('student/add', [StudentController::class, "add"])->name('student.add');
    // Handle the form submission to add a new student
    Route::post('student/add', [StudentController::class, "store"])->name('student.store');
    // Show the form to edit an existing student
    Route::get('student/edit/{id}', [StudentController::class, "edit"])->name('student.edit');
    // Handle the form submission to update an existing student
    Route::put('student/edit/{id}', [StudentController::class, "update"])->name('student.update');
    // Handle the deletion of a student
    Route::get('student/delete/{id}', [StudentController::class, "delete"])->name('student.delete');
    // Route to fetch students by class


   // Manages Subjects
   Route::resource('subjects', SubjectController::class);
     Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
   
// Students Routes
// Student Marks Routes
Route::prefix('students')->name('students.')->group(function () {
    Route::resource('marks', MarksController::class)->except(['show']);
});

// All Marks
Route::resource('marks', MarksController::class);
Route::get('/marks/{class}/students', [MarksController::class, 'getStudents']);
Route::get('/marks/{class}/subjects', [MarksController::class, 'getSubjects']);

});
Route::middleware(['Student'])->group(function () {
    Route::get('student/dashboard', [DashboardController::class, "dashboard"]);
    // Route::get('/student/dashboard/result/{student}', [DashboardController::class, 'resultview'])
    //     ->name('student.result');
    Route::get('/student/marksheet', [StudentController::class, 'marksheet'])
        ->name('student.marksheet');
});
