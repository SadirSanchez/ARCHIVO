<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;  // Controlador de usuarios
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la aplicación.
|
*/

// Ruta raíz que redirige a login
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard protegido por middleware auth y verified
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas protegidas para el perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de rutas protegidas para Documents
Route::middleware('auth')->group(function () {
    Route::get('/Documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/Documents/receive', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/Documents/consult', [DocumentController::class, 'getDocuments'])->name('documents.getDocuments');
    Route::put('/Documents/update/{id}', [DocumentController::class, 'update'])->name('documents.update');
    Route::put('/Documents/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
});

// Rutas para gestionar usuarios
Route::middleware(['auth', 'verified'])->group(function () {
    // Página principal de usuarios (listar usuarios)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Página para mostrar el formulario de registro
    Route::get('/users/register', [RegisteredUserController::class, 'create'])->name('users.register');

    // Procesar el registro del nuevo usuario
    Route::post('/users/register', [RegisteredUserController::class, 'store'])->name('users.register.store');
});

// Ruta original de registro global (para usuarios externos)
Route::get('/users/register', [RegisteredUserController::class, 'create'])->name('users.register');
Route::post('/users/register', [RegisteredUserController::class, 'store'])->name('users.register.store');


// Rutas de autenticación de Laravel Breeze o Jetstream
require __DIR__ . '/auth.php';
