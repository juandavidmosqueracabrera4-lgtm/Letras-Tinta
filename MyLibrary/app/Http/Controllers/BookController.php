<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    //lista de libros con sus autores y categorias
    public function index()
    {
        $books = Book::with(['authors', 'categories'])->get();
        return response()->json($books);
    }

    // Método para retornar la vista del formulario con la lista de autores
     public function create()
    {
        $authors = \App\Models\Author::all(); // Trae los autores para el menú desplegable
        return view('books.create', compact('authors')); // Abre resources/views/books/create.blade.php
    }


    //guardar un nuevo libro y asociarlo en las tablas intermedias
    public function store(StoreBookRequest $request)
    {
    // Crea el libro con los campos validados básicos
    $book = Book::create([
        'title' => $request->title,
        'isbn' => $request->isbn,
        'available_copies' => $request->available_copies,
        'status' => 'available' // Estado por defecto según el diagrama del profesor
    ]);

    // Asocia los múltiples IDs de autores en la tabla pivote intermedia
    if ($request->has('author_ids')) {
        $book->authors()->attach($request->author_ids);
    }

    return response()->json([
        'message' => 'Libro registrado exitosamente con sus autores',
        'book' => $book->load('authors')
    ], 201);
    }
}
