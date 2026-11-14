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
    Route::middleware(['role:admin,bibliotecario,lector', 'authorized:books.view'])->group(function () {
        Route::get('/libros', [BookController::class, 'index'])->name('books.index');
    });

    // LIBROS: Solo admin y bibliotecario pueden crear, editar y eliminar
    Route::middleware(['role:admin,bibliotecario', 'authorized:books.create'])->group(function () {
        Route::get('/libros/crear', [BookController::class, 'create'])->name('books.create');
        Route::post('/libros/guardar', [BookController::class, 'store'])->name('books.store');
    });

    Route::middleware(['role:admin,bibliotecario', 'authorized:books.edit'])->group(function () {
        Route::get('/libros/editar/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/libros/actualizar/{id}', [BookController::class, 'update'])->name('books.update');
    });

    Route::middleware(['role:admin,bibliotecario', 'authorized:books.delete'])->group(function () {
        Route::delete('/libros/eliminar/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // LIBROS: Detalle individual
    // Solo admin, bibliotecario y lector pueden ver el detalle de un libro
    Route::middleware(['role:admin,bibliotecario,lector', 'authorized:books.view'])->group(function () {
        Route::get('/libros/{id}', [BookController::class, 'show'])->name('books.show');
    });

    // 2. PRÉSTAMOS: Consulta
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.view'])->group(function () {
        Route::get('/prestamos', [LoanController::class, 'index'])->name('loans.index');
    });

    // PRÉSTAMOS: Creación
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.create'])->group(function () {
        Route::get('/prestamos/crear', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/prestamos/procesar', [LoanController::class, 'store'])->name('loans.store');
    });

    // PRÉSTAMOS: Edición
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.edit'])->group(function () {
        Route::get('/prestamos/editar/{id}', [LoanController::class, 'edit'])->name('loans.edit');
        Route::put('/prestamos/actualizar/{id}', [LoanController::class, 'update'])->name('loans.update');
    });

    // PRÉSTAMOS: Eliminación
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.delete'])->group(function () {
        Route::delete('/prestamos/eliminar/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
    });

    // PRÉSTAMOS: Registrar devolución
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.return'])->group(function () {
        Route::post('/prestamos/devolver/{id}', [LoanController::class, 'returnLoan'])->name('loans.return');
    });

    // PRÉSTAMOS: Detalle individual
    Route::middleware(['role:admin,bibliotecario', 'authorized:loans.view'])->group(function () {
        Route::get('/prestamos/{id}', [LoanController::class, 'show'])->name('loans.show');
    });

    // Rutas para guardar autores y categorías
    Route::middleware(['role:admin,bibliotecario'])->group(function () {

        // Permisos para autores
        Route::middleware(['authorized:authors.create'])->group(function () {
            Route::post('/autores/guardar', [BookController::class, 'storeAuthor'])->name('authors.store');

            Route::get('/autores/crear', function () {
                return view('authors.create');
            })->name('authors.create');
        });

        // Permisos para categorías
        Route::middleware(['authorized:categories.create'])->group(function () {
            Route::post('/categorias/guardar', [BookController::class, 'storeCategory'])->name('categories.store');

            Route::get('/categorias/crear', function () {
                return view('categories.create');
            })->name('categories.create');
        });
    });

    // 3. USUARIOS: Exclusivo para admin
    // Consultar usuarios
    Route::middleware(['role:admin', 'authorized:users.view'])->group(function () {
        Route::get('/usuarios', [UsersController::class, 'index'])->name('users.index');
    });

    // Crear usuarios
    Route::middleware(['role:admin', 'authorized:users.create'])->group(function () {
        Route::get('/usuarios/crear', [UsersController::class, 'create'])->name('users.create');
        Route::post('/usuarios/guardar', [UsersController::class, 'store'])->name('users.store');
    });

    // Editar usuarios
    Route::middleware(['role:admin', 'authorized:users.edit'])->group(function () {
        Route::get('/usuarios/editar/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/actualizar', [UsersController::class, 'update'])->name('users.update');
    });

    // Eliminar usuarios
    Route::middleware(['role:admin', 'authorized:users.delete'])->group(function () {
        Route::delete('/usuarios/eliminar/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
});
