<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fededge - Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <i class="bi bi-key-fill"></i>
                <h2>Reset Password</h2>
                <p>Recover Your Account Access</p>
            </div>

            <div class="auth-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-circle"></i> Error</strong><br>
                        Please check the information provided and try again.
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <input
                            type="email"
                            class="auth-form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your registered email"
                            required
                            autofocus
                        >
                        @error('email')
                            <div class="auth-error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <p class="form-text">
                        <i class="bi bi-info-circle"></i> Enter the email address associated with your Fededge account. We'll send you instructions to reset your password.
                    </p>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send"></i> Send Reset Link
                    </button>
                </form>

                <div class="back-link">
                    <p>Remember your password?</p>
                    <a href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In Here
                    </a>
                </div>

                <div class="info-box">
                    <strong><i class="bi bi-shield-check"></i> Security Notice</strong>
                    We take your security seriously. The reset link will expire in 60 minutes for your protection. If you didn't request a password reset, you can safely ignore this email.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
