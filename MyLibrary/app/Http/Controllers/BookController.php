<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\StoreLoanRequest;
use App\Models\Book;

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
        //el Request validado ya usa 'available_copies' y 'status'
        $book = Book::create($request->validated());

        //asociar los IDs de autores y categorias en las tablas pivote
        if ($request->has('author_ids')){
            $book->authors()->attach($request->author_ids);
        }

        if ($request->has('category_ids')){
            $book->categories()->attach($request->category_ids);
        }

        return response()->json(['message' => 'Libro creado con éxito', 'book' => $book], 201);
    }

}
