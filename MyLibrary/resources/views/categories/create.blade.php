@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <div class="container mt-5" style="max-width: 600px;">

        {{-- Formulario para agregar un nueva categoria --}}
        <form action="{{ route('categories.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            <h3 class="mb-4">Add New Category</h3>

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
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save Category</button>
            </div>
        </form>
    </div>
@endsection
