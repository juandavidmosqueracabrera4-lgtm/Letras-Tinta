<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
class BookController extends Controller
{
    // Mostrar el catálogo de libros
    public function index()
    {
        $books = Book::with(['authors', 'categories'])->get();
         return view('books.index', compact('books'));
    }

    // Método para retornar la vista del formulario con la lista de autores
     public function create()
    {
        $authors = \App\Models\Author::all(); // Trae los autores para el menú desplegable
        $categories = \App\Models\Category::all(); // Trae las categorías para el menú desplegable
        return view('books.create', compact('authors', 'categories')); // Abre resources/views/books/create.blade.php
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

    if ($request->filled('category_ids')) {
        $book->categories()->attach($request->category_ids);
    }
        return redirect()
        ->route('books.index')
        ->with('success', 'Libro registrado exitosamente.');
    }

    //metodo para eliminar un libro y limpiar sus relaciones muchos a muchos
    public function destroy($id)
    {
        // 1. buscar un libro por su id o arrojar un error 404 si no existe
        $book = Book::findOrFail($id);

        // 2. Desvincular de forma manual sus autores y categorías en las tablas pivote
        // Esto limpia de inmediato las tablas 'book_authors' y 'book_categories'
        $book->authors()->detach();
        $book->categories()->detach();

        // 3. Eliminar el registro físico del libro en la tabla 'books'
        $book->delete();

        // 4. Retornar una respuesta JSON exitosa para el frontend
        return response()->json([
        'message' => 'El libro fue eliminado correctamente y se limpiaron sus relaciones del sistema.'
         ], 200);
    }


}
