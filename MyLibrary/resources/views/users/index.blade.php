@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>User Management</h2>
        <p class="text-muted">Manage the registered users.</p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        Add User
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        @if($users->isEmpty())
            <div class="alert alert-info mb-0">
                There are no registered users yet.
            </div>
        @else

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Document</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->document }}</td>
                                <td>{{ $user->role->name ?? 'No role assigned' }}</td>

                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        @endif

    </div>
</div>

@endsection