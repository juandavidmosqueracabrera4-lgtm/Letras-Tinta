
@extends('layouts.app')

@section('title', 'Register Loan')

@section('content')

<div class="mb-4">
    <h2>Register Loan</h2>
    <p class="text-muted">
        Enter the information to register a new loan.
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

        <form action="{{ route('loans.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">
                    User
                </label>

                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">
                        Select a user
                    </option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label for="book_id" class="form-label">
                    Book
                </label>

                <select class="form-select" id="book_id" name="book_id" required>
                    <option value="">Select a book</option>

                    @foreach($books as $book)
                        @if($book->available_copies > 0)
                            <option value="{{ $book->id }}"
                                {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} ({{ $book->available_copies }} available)
                            </option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label for="loan_date" class="form-label">Loan Date</label>

                <input
                    type="date"
                    class="form-control"
                    id="loan_date"
                    name="loan_date"
                    value="{{ old('loan_date') }}"
                    required
                >
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Register Loan
                </button>

                <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
