@extends('layouts.app')

@section('title', 'Add Author')

@section('content')
    <div class="container mt-5" style="max-width: 600px;">

        {{-- Formulario para agregar un nuevo autor --}}
        <form action="{{ route('authors.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            <h3 class="mb-4">Add New Author</h3>

            {{-- Condicion de errores de validacion --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Campos del formulario --}}
            <div class="mb-3">
                <label for="name" class="form-label">Author Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('books.create') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save Author</button>
            </div>
        </form>
    </div>
@endsection
