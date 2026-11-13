@extends('layouts.app')

@section('title', 'Loans')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>
            Loan Management
        </h2>
        <p class="text-muted">
            Manage the registered loans.
        </p>
    </div>

    <a href="{{ route('loans.create') }}" class="btn btn-primary">
        Register Loan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">

        @if($loans->isEmpty())
            <div class="alert alert-info mb-0">
                There are no registered loans yet.
            </div>
        @else

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Loan Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->user->name ?? 'Unknown' }}</td>
                                <td>{{ $loan->book->title ?? 'Unknown' }}</td>
                                <td>{{ $loan->loan_date }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('loans.show', $loan->id) }}"
                                        class="btn btn-sm btn-info">
                                            View
                                    </a>
                                    <a href="{{ route('loans.show', $loan->id) }}"
                                        class="btn btn-sm btn-info">
                                            Edit
                                    </a>

                                    <a href="{{ route('loans.show', $loan->id) }}"
                                        class="btn btn-sm btn-info">
                                            Delete
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
