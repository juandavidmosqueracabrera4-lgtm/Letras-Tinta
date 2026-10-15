<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title> Biblioteca- Lista de Libros </title>
    <link rel="stylesheet" href="https://jsdelivr.net">

</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Catálogo de Libros</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Agregar Libro</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table bordered">
        <thead class="table-dark">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Copias Disponibles</th>
            </tr>
        </thead>

        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name ?? 'Sin autor asignado' }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No hay libros registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
<html>

