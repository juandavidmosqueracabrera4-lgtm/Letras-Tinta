
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

// Enlaces web para la administración de los libros
Route::get('/libros', [BookController::class, 'index'])->name('books.index');
Route::get('/libros/crear', [BookController::class, 'create'])->name('books.create');
Route::post('/libros/guardar', [BookController::class, 'store'])->name('books.store');
Route::get('/libros/editar/{id}', [BookController::class, 'edit'])->name('books.edit');
Route::get('/libros/{id}', [BookController::class, 'show'])->name('books.show');
Route::put('/libros/actualizar/{id}', [BookController::class, 'update'])->name('books.update');
Route::delete('/libros/eliminar/{id}', [BookController::class, 'destroy'])->name('books.destroy');

// Enlaces web para la administración de préstamos
Route::get('/prestamos', [LoanController::class, 'index'])->name('loans.index');
Route::get('/prestamos/crear', [LoanController::class, 'create'])->name('loans.create');
Route::post('/prestamos/procesar', [LoanController::class, 'store'])->name('store.loans');
Route::get('/prestamos/{id}', [LoanController::class, 'show'])->name('loans.show');

// Enlaces web para la administración de usuarios
Route::get('/usuarios', [UsersController::class, 'index'])->name('users.index');
Route::get('/usuarios/crear', [UsersController::class, 'create'])->name('users.create');
Route::post('/usuarios/guardar', [UsersController::class, 'store'])->name('users.store');
Route::get('/usuarios/editar/{id}', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/usuarios/actualizar', [UsersController::class, 'update'])->name('users.update');
Route::delete('/usuarios/eliminar/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
