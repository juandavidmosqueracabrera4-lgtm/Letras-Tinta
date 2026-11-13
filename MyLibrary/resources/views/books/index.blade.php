@extends('layouts.app')

@section('title', 'Book Catalog')

@section('content')

<div class="container mt-5">
    <!-- Encabezado del catálogo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Book Catalog</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
    </div>

    <!-- Mensaje de operación exitosa -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla con los libros registrados -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Categories</th>
                <th>ISBN</th>
                <th>Total Copies</th>
                <th>Available Copies</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <!-- Recorrer los libros recibidos del controlador -->
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->title }}
                        <br>
                        <a href="{{ route('books.show', $book->id) }}">
                            View details
                        </a>
                    </td>
                    <td>{{ $book->authors->pluck('name')->join(', ') ?: 'No author assigned' }}</td>
                    <td>{{ $book->categories->pluck('name')->join(', ') ?: 'No category assigned' }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->total_copies }}</td>
                    <td>{{ $book->available_copies }}</td>
                    <td>
                        <!-- Botón para editar -->
                        <a href="{{ route('books.edit', $book->id) }}"
                            class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Formulario para eliminar un libro -->
                        <form action="{{ route('books.destroy', $book->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this book')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                              Delete
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <!-- Mensaje cuando no hay libros registrados -->
                <tr>
                    <td colspan="7" class="text-center">
                        No books are registered.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection

