<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas públicas de Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rutas protegidas por sesión activa ('auth')
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. LIBROS: Catálogo general
    Route::middleware(['role:admin,bibliotecario,lector'])->group(function () {
        Route::get('/libros', [BookController::class, 'index'])->name('books.index');
    });

    // LIBROS: Solo admin y bibliotecario pueden crear, editar y eliminar (ANTES de /libros/{id})
    Route::middleware(['role:admin,bibliotecario'])->group(function () {
        Route::get('/libros/crear', [BookController::class, 'create'])->name('books.create');
        Route::post('/libros/guardar', [BookController::class, 'store'])->name('books.store');
        Route::get('/libros/editar/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/libros/actualizar/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/libros/eliminar/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // LIBROS: Detalle individual (AL FINAL para que {id} no capture "/libros/crear")
    Route::middleware(['role:admin,bibliotecario,lector'])->group(function () {
        Route::get('/libros/{id}', [BookController::class, 'show'])->name('books.show');
    });

    // 2. PRÉSTAMOS: Solo admin y bibliotecario
    Route::middleware(['role:admin,bibliotecario'])->group(function () {
        Route::get('/prestamos', [LoanController::class, 'index'])->name('loans.index');
        Route::get('/prestamos/crear', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/prestamos/procesar', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/prestamos/{id}', [LoanController::class, 'show'])->name('loans.show');

        Route::get('/prestamos/editar/{id}', [LoanController::class, 'edit'])->name('loans.edit');
        Route::put('/prestamos/actualizar/{id}', [LoanController::class, 'update'])->name('loans.update');
        Route::post('/prestamos/devolver/{id}', [LoanController::class, 'returnLoan'])->name('loans.return');
        Route::delete('/prestamos/eliminar/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');

        //rutas para guardar autores y categorias
        Route::post('/autores/guardar', [BookController::class, 'storeAuthor'])->name('authors.store');
        Route::post('/categorias/guardar', [BookController::class, 'storeCategory'])->name('categories.store');
        Route::get('/autores/crear', function () {
            return view('authors.create');
        })->name('authors.create');
        Route::get('/categorias/crear', function () {
            return view('categories.create');
        })->name('categories.create');

    });

    // 3. USUARIOS: Exclusivo para admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/usuarios', [UsersController::class, 'index'])->name('users.index');
        Route::get('/usuarios/crear', [UsersController::class, 'create'])->name('users.create');
        Route::post('/usuarios/guardar', [UsersController::class, 'store'])->name('users.store');
        Route::get('/usuarios/editar/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/actualizar', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/usuarios/eliminar/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
});
