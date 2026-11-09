
@extends('layouts.app')

@section('title', 'Loan Details')

@section('content')

<div class="mb-4">
    <h2>Loan Details</h2>
    <p class="text-muted">
        View the information about this loan.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="mb-3">
            <strong>Loan ID:</strong>
            <span>{{ $loan->id }}</span>
        </div>

        <div class="mb-3">
            <strong>User:</strong>
            <span>{{ $loan->user->name ?? 'Unknown' }}</span>
        </div>

        <div class="mb-3">
            <strong>Email:</strong>
            <span>{{ $loan->user->email ?? 'Unknown' }}</span>
        </div>

        <div class="mb-3">
            <strong>Book:</strong>
            <span>{{ $loan->book->title ?? 'Unknown' }}</span>
        </div>

        <div class="mb-3">
            <strong>Loan Date:</strong>
            <span>{{ $loan->loan_date }}</span>
        </div>

        <div class="mb-3">
            <strong>Status:</strong>
            <span class="badge bg-success">
                {{ ucfirst($loan->status) }}
            </span>
        </div>

        <a href="{{ route('loans.index') }}" class="btn btn-secondary">
            Back to Loans
        </a>

    </div>
</div>

@endsection