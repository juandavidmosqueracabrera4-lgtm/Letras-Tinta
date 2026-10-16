<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add New Book</title>

     <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    </head>

    <body class="container mt-5" style ="max-width: 600px;">

    <h1>New Book</h1>
    <form action="{{ route('books.store') }}" method="POST"
    class="card p-4 shadow-sm">

    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">
            Book Title
        </label>

        <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
                required>
        </div>

        <div class="mb-3">
            <label for="author_id" class="form-label">
                Author;
            </label>

            <select
                    id="author_id"
                    name="author_id"
                    class="form-select"
                    required>
                <option value="">Select an author</option>

                @foreach($authors as $author)
                    <option value="{{ $author->id }}"
                        {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach

                </select>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">
                ISBN
            </label>

            <input
                    type="text"
                    id="isbn"
                    name="isbn"
                    class="form-control"
                    value="{{ old('isbn') }}"
                    required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">
                Available Copies
            </label>

            <input
                    type="number"
                    id="stock"
                    name="stoc"
                    class="form-control"
                    value="{{ old('stock', 1) }}"
                    required>
        </div>

           <div class="d-flex justify-content-between">
            <a href="{{ route('books.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-success">
                Save Book
            </button>
        </div>

    </form>

</body>
</html>



