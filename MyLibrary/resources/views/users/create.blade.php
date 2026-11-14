
@extends('layouts.app')

@section('title', 'Create User')

@section('content')

<div class="mb-4">
    <h2>
        Create User
    </h2>
    <p class="text-muted">
        Register a new user in the system.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            {{--Mensaje de duplicacion en docuemnto o correo--}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name"
                       class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                       class="form-control" value="{{ old('email') }}" required>
            </div>

            {{--Campo de contraseña eliminado ya que se genera automáticamente con el documento en el controlador UsersController--}}
            {{--<div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>--}}

            <div class="mb-3">
                <label for="document" class="form-label">
                    Document
                </label>
                <input type="text" name="document" id="document"
                       class="form-control" value="{{ old('document') }}" required>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">
                    Role
                </label>
                <select name="role_id" id="role_id" class="form-select" required>
                    <option value="">
                        Select a role
                    </option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Save User
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
