<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyLibrary - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <br>
    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-primary alert-dismissible fade show container" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <!-- Landing Page -->
    <section id="landingSection"
        class="vh-100 d-flex align-items-center justify-content-center flex-column text-center">
        <h1 class="display-4">Welcome to <strong>MyLibrary</strong></h1>
        <p class="lead">Manage and track your personal book collection with ease.</p>
        <button class="btn btn-primary mt-3" onclick="scrollToAuth('login'); toggleForm('login')">Login /
            Register</button>
    </section>

    <!-- Auth Section -->
    <section id="authSection" class="vh-100 d-none align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Buttons -->
                    <div class="text-center mb-4">
                        <button class="btn btn-outline-primary me-2" onclick="toggleForm('login')">Login</button>
                        <button class="btn btn-outline-success" onclick="toggleForm('register')">Register</button>
                    </div>
                    <!-- Login Form -->
                    <div class="form-section active" id="loginForm">
                        <div class="card p-4">
                            <h3 class="mb-3">Login</h3>
                            <form method="post" action="/user/login">
                                @csrf
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="loginEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" name="password"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div class="form-section" id="registerForm">
                        <div class="card p-4">
                            <h3 class="mb-3">Register</h3>
                            <form method="POST" action="/user/register">
                                @csrf
                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="registerName" required
                                        name="name">
                                    @error('confirmPassword')
                                        <p class="text-danger"><small>{{ $message }}</small></p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="registerEmail" required
                                        name="email">
                                    @error('confirmPassword')
                                        <p class="text-danger"><small>{{ $message }}</small></p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="registerPassword" required
                                        name="password">
                                    @error('confirmPassword')
                                        <p class="text-danger"><small>{{ $message }}</small></p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Confirm password</label>
                                    <input type="password" class="form-control" id="registerPassword" required
                                        name="password_confirmation">
                                    @error('password_confirmation')
                                        <p class="text-danger"><small>{{ $message }}</small></p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success w-100">Register</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        function scrollToAuth(type) {
            // Show auth section if hidden
            document.getElementById('authSection').classList.remove('d-none');

            // Scroll to it
            document.getElementById('authSection').scrollIntoView({
                behavior: 'smooth'
            });

            // Activate the correct form
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });

            if (type === 'login') {
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('registerForm').classList.add('active');
            }
        }

        function toggleForm(type) {
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });

            if (type === 'login') {
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('registerForm').classList.add('active');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
