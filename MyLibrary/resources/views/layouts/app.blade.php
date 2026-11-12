
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Letras y Tinta')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Letras y Tinta
            </a>

            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('books.index') }}">
                    Books
                </a>
                <a class="nav-link" href="{{ route('users.index') }}">
                    Users
                </a>
                <a class="nav-link" href="{{ route('loans.index') }}">
                    Loans
                </a>
            </div>

            @auth
                <div class="d-flex align-items-center ms-auto">
                    <span class="navbar-text text-light me-3">
                        {{ auth()->user()->name }} ({{ auth()->user()->role->name ?? 'Sin rol' }})
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Sign out</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="container mt-4">

        @if(session('message'))
            <div class="alert alert-{{ session('message.type') }}">
                {{ session('message.content') }}
            </div>
        @endif

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
