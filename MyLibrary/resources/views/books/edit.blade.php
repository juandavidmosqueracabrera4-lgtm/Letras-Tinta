@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')

<div class="container mt-5" style="max-width: 600px;">
<h1>Edit Book</h1>
<p class="text-muted">
    Update the information of the book.
</p>

        <form action="{{ route('books.update', $book->id) }}"
            method="POST"
            class="card p-4 shadow-sm">

        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach

                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">
                Book Title
            </label>

            <input
            type="text"
            id="title"
            name="title"
            class="form-control"
            value="{{ old('title', $book->title) }}"
            required>

        </div>

        <div class="mb-3">
        <label for="authors_ids"
        class="form-label">
            Authors
        </label>

        <select
            id="author_ids"
            name="author_ids[]"
            class="form-select"
            multiple required>

            @foreach($authors as $author)
                <option value="{{ $author->id}}"
                    {{ in_array($author->id, old('author_ids', $book->authors->pluck('id')->toArray())) ? 'selected' : ''}}>
                    {{ $author->name }}
                </option>
                @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label for="category_ids" class="form-label">
            Categories
        </label>

            <select
                id="category_ids"
                name="category_ids[]"
                class="form-select"
                multiple>

                @foreach($categories as $category)

                    <option value="{{$category->id}}"
                        {{ in_array($category->id, old('category_ids', $book->categories->pluck('id')->toArray())) ? 'selected' : ''}}>
                        {{ $category->name }}
                    </option>
                @endforeach

                </select>
            </div>

            <div class= "mb-3">
                <label for ="isbn" class="form-label">
                    ISBN
                </label>

                <input
                    type="text"
                    id="isbn"
                    name="isbn"
                    class="form-control"
                    value="{{ old('isbn', $book->isbn) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="total_copies" class="form-label">
                    Total Copies
                </label>

                <input
                    type="number"
                    id="total_copies"
                    name="total_copies"
                    class="form-control"
                    value="{{ old('total_copies', $book->total_copies) }}"
                    min="0"
                    required>
            </div>

            <div class="mb-3">
                <label for="available_copies" class="form-label">
                    Available Copies
                </label>

                <input
                    type="number"
                    id="available_copies"
                    name="available_copies"
                    class="form-control"
                    value="{{ old('available_copies', $book->available_copies) }}"
                    min="0"
                    required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('books.index') }}"
                class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit"
                class="btn btn-success">
                    Update Book
                </button>
            </div>
        </form>

</div>
@endsection
