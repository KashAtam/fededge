<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fededge - Create New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <i class="bi bi-lock-fill"></i>
                <h2>Create New Password</h2>
                <p>Secure Your Account</p>
            </div>

            <div class="auth-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-circle"></i> Error</strong><br>
                        Please correct the errors below and try again.
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <input
                            type="email"
                            class="auth-form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                        @error('email')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">New Password</label>
                        <input
                            type="password"
                            class="auth-form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Create a strong password"
                            required
                        >
                        @error('password')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <div class="password-requirements">
                            <strong><i class="bi bi-shield-lock"></i> Password Requirements:</strong>
                            <ul>
                                <li>At least 8 characters</li>
                                <li>Uppercase letters (A-Z)</li>
                                <li>Lowercase letters (a-z)</li>
                                <li>Numbers (0-9)</li>
                                <li>Special symbols (!@#$%^&*)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="auth-form-group">
                        <label for="password_confirmation" class="auth-form-label">Confirm Password</label>
                        <input
                            type="password"
                            class="auth-form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            required
                        >
                        @error('password_confirmation')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i> Reset Password
                    </button>
                </form>

                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Back to Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
