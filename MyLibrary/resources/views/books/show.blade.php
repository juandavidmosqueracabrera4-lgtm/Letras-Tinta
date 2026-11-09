@extends('layouts.app')

@section('title', 'Book Details')

@section('content')

<div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Book Details</h1>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                Back to catalog
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <h3 class="card-title mb-4">{{ $book->title }}</h3>

                <p>
                    <strong>ISBN:</strong>
                    {{ $book->isbn }}
                </p>

                <p>
                    <strong>Authors:</strong>
                    {{ $book->authors->pluck('name')->join(', ') }}
                </p> 

                
                <p>
                    <strong>Categories:</strong>
                    @forelse($book->categories as $category)
                        {{ $category->name }}@if (!$loop->last), @endif
                    @empty
                         No category assigned
                    @endforelse
                </p>

                <p>
                    <strong>Available Copies:</strong>
                    {{ $book->available_copies }}
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ $book->status }}
                </p>

            </div>
        </div>

</div>
@endsection
