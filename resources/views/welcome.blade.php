<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daily Task Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="antialiased">
    <div class="container">
        @if (Route::has('login'))
            <div class="auth-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">
            <h1>Welcome to the Daily Task Management System</h1>
            <p>Start with your daily homework and follow up on each one and check your achievements.</p>
        </div>

        <footer class="social-media">
            <p>Follow us on:</p>
            <a href="https://facebook.com" class="social-link">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="https://linkedin.com" class="social-link">
                <i class="bi bi-linkedin"></i>
            </a>
            <a href="https://instagram.com" class="social-link">
                <i class="bi bi-instagram"></i>
            </a>



    </div>

    <script src="script.js"></script> <!-- Link to external JavaScript file -->
</body>

</html>
