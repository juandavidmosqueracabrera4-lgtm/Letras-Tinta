<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

//enlaces web para la administraciòn de los libros
Route::get('/libros', [BookController::class, 'index'])->name('books.index');
Route::get('/libros/crear', [BookController::class, 'create'])->name('books.create');
Route::post('/libros/guardar', [BookController::class, 'store'])->name('books.store');
Route::delete('/libros/eliminar/{id}', [BookController::class, 'destroy'])->name('books.destroy');

//enlaces web para la administracion de prestamos
Route::get('/prestamos', [LoanController::class, 'index']);
Route::post('/prestamos/procesar', [LoanController::class, 'store']);
