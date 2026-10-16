<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Book Catalog</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Available Copies</th>
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
                        No books are registered.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
<html>

