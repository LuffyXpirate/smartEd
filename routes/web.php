<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ReportController;

Route::get('/', [AuthController::class, "login"]); // Optional: Redirect '/' to the login page
Route::get('/login', [AuthController::class, "login"]); // Display the login page
Route::post('/login', [AuthController::class, "authlogin"]); // Handle login form submission
Route::get('/logout', [AuthController::class, "logout"]);


Route::middleware(['Admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('admin/list', [AdminController::class, "list"]);
    Route::get('admin/add', [AdminController::class, "add"]);
    Route::post('admin/add', [AdminController::class, "Addadmin"]);
    Route::get('admin/edit/{id}', [AdminController::class, "edit"]);
    Route::put('admin/edit/{id}', [AdminController::class, "update"]);
    Route::get('admin/delete/{id}', [AdminController::class, "delete"]);

    Route::get('admin/student/report/{student}', [ReportController::class, 'generateReport'])->name('student.report');

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
Route::get('/students/by-class/{class}', [StudentController::class, 'getStudentsByClass']);


    //Manages Subjects
    Route::get('subject/list', [SubjectController::class, 'list'])->name('subject.list');
    Route::post('subject/add', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('subject/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::put('subject/edit/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::get('subject/delete/{id}', [SubjectController::class, 'destroy'])->name('subject.delete');


    //manages marks
    Route::get('marks/list',[MarksController::class,'list'])->name('marks.list');
    Route::get('marks/add',[MarksController::class,'add'])->name('marks.add');
    Route::post('marks/add',[MarksController::class,'store'])->name('marks.store');
    Route::get('marks/edit/{id}', [MarksController::class, 'edit'])->name('marks.edit');
    Route::put('marks/edit/{id}', [MarksController::class, 'update'])->name('marks.update');    
    Route::delete('marks/delete/{id}',[MarksController::class,'destroy'])->name('marks.delete');

});

Route::middleware(['Student'])->group(function () {
    Route::get('student/dashboard', [DashboardController::class, "dashboard"]);
    
});

