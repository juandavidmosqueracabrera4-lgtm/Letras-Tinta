
@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="mb-4">
    <h2>Edit User</h2>
    
    <p class="text-muted">
        Update the user's information.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update') }}" method="POST">

            @csrf
            @method('PUT')

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">
                    Full Name
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    Email
                </label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">
                    Role
                </label>
                <select
                    class="form-select"
                    id="role_id"
                    name="role_id"
                    required
                >
                    <option value="">
                        Select a role
                    </option>

                    @foreach($roles as $role)
                        <option
                            value="{{ $role->id }}"
                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}
                        >
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
