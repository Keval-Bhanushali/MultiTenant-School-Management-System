<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Login | SchoolHub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/unified-4d.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="fx-page">
    <!-- 3D Canvas Background -->
    <canvas id="canvas" class="fx-canvas" data-fx-network></canvas>

    <div class="fx-atmosphere" aria-hidden="true">
        <span class="a"></span>
        <span class="b"></span>
        <span class="c"></span>
    </div>

    <div class="edu-icon-cloud" aria-hidden="true">
        <i class="fa-solid fa-graduation-cap" style="left:6%; top:16%; font-size:44px; --rot:-14deg; --dur:16s;"></i>
        <i class="fa-solid fa-book-open" style="left:18%; top:74%; font-size:38px; --rot:10deg; --dur:18s; --delay:-2s;"></i>
        <i class="fa-solid fa-school" style="right:12%; top:22%; font-size:42px; --rot:-6deg; --dur:20s; --delay:-4s;"></i>
        <i class="fa-solid fa-pencil" style="right:20%; top:76%; font-size:32px; --rot:22deg; --dur:14s; --delay:-3s;"></i>
        <i class="fa-solid fa-flask" style="left:44%; top:10%; font-size:28px; --rot:6deg; --dur:17s; --delay:-5s;"></i>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-box fx-tilt">
            <div class="login-header">
                <div class="login-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h1 class="login-title">SchoolHub</h1>
                <p class="login-subtitle">Secure Management Portal</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() ?? 'Invalid credentials. Please try again.' }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="role-hint">
                <strong>🎓 Role-Based Login:</strong>
                superadmin • admin • staff • teacher • student
            </div>
        </div>
    </div>
    <script src="{{ asset('js/unified-4d.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
