<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Application;
use App\Models\Project;
use App\Models\Profile;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProjectFileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/plist', function () {
    $projectList = Project::withCount(['applications', 'assignedStudents'])
        ->orderBy('year', 'desc')
        ->orderBy('trimester', 'desc')
        ->get()
        ->groupBy(['year', 'trimester']);

    return view('project.projectList')->with('projects', $projectList);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// by define all routes inside the auth group method, all user have to login first to use all functions
Route::middleware('auth')->group(function () {
    Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/',UsersController::class);
    Route::resource('u',UsersController::class);
    Route::resource('application',ApplicationController::class);
    Route::resource('project',ProjectsController::class);
    Route::resource('file',ProjectFileController::class);
});

// only teacher can Access the below function/URL
Route::get('/allStudent', [UsersController::class, 'showStudents'])->middleware('auth', 'Reacher');
Route::post('/approve-inp/{id}', [UsersController::class, 'approveInp'])->middleware('auth', 'Teacher')->name('approveInp');
Route::get('/profile/all', [ProfileController::class, 'index'])->middleware('auth', 'Teacher')->name('profile.index');
Route::get('/users/auto-assign', [UsersController::class, 'autoAssign'])->middleware('auth', 'Teacher')->name('users.autoAssign');



require __DIR__.'/auth.php';
