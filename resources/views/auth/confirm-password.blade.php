<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fededge - Confirm Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <i class="bi bi-shield-check"></i>
                <h2>Confirm Password</h2>
                <p>Security Verification Required</p>
            </div>

            <div class="auth-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-circle"></i> Authentication Failed</strong><br>
                        The password you entered is incorrect. Please try again.
                    </div>
                @endif

                <div class="security-notice">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <strong>Secure Area</strong><br>
                        This is a sensitive area of your account. For your protection, please confirm your password to continue.
                    </div>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">Password</label>
                        <input
                            type="password"
                            class="auth-form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autofocus
                            autocomplete="current-password"
                        >
                        @error('password')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg"></i> Confirm & Continue
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
