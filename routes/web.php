<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentUserController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');   
});

// Admin Dashboard
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/data', [TeacherController::class, 'data'])->name('teachers.data');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');    
});


// Teacher Dashboard
Route::middleware(['auth', RoleMiddleware::class . ':teacher'])->group(function () {
    /**students routes */
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{students}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{students}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
  
   /**parentUsers routes */
    Route::get('/parentUsers/create', [ParentUserController::class, 'create'])->name('parentUsers.create');
    Route::post('/parentUsers/store', [ParentUserController::class, 'store'])->name('parentUsers.store');
    Route::get('/parentUsers/{parentUsers}/edit', [ParentUserController::class, 'edit'])->name('parentUsers.edit');
    Route::put('/parentUsers/{parentUsers}', [ParentUserController::class, 'update'])->name('parentUsers.update');
    Route::delete('/parentUsers/{id}', [ParentUserController::class, 'destroy'])->name('parentUsers.destroy');
});

// Or for multiple roles both admin & teacher
Route::middleware(['auth', RoleMiddleware::class . ':admin,teacher'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/parentUsers', [ParentUserController::class, 'index'])->name('parentUsers.index');
    Route::get('/students/data', [StudentController::class, 'data'])->name('students.data');
    Route::get('/parentUsers/data', [ParentUserController::class, 'data'])->name('parentUsers.data');
});

require __DIR__.'/auth.php';
