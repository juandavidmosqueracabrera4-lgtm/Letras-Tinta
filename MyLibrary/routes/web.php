<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BookController;
use App\Http\Contrallers\LoanController;

//enlaces web para la administraciòn de los libros
Route::get('/libros', [BookController::class, 'index']);
Route::post('/libros/guardar', [BookController::class, 'store']);
Route::delete('/libros/eliminar/{id}', [BookController::class, 'destroy']);

//enlaces web para la administracion de prestamos
Route::get('/prestamos', [LoanController::class, 'index']);
Route::post('/prestamos/procesar', [LoanController::class, 'store']);