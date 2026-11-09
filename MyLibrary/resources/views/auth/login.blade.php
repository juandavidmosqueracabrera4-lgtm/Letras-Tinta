
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Letras y Tinta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h2>Letras y Tinta</h2>
                            <p class="text-muted">
                                Sign in to your account
                            </p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if(session('message'))
                            <div class="alert alert-{{ session('message.type') }}">
                                {{ session('message.content') }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Sign In
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
