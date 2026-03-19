<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchoolHub - Next Generation School Management</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/unified-4d.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body class="fx-page">
    <!-- 3D Canvas for animations -->
    <canvas id="canvas3d" class="fx-canvas" data-fx-network></canvas>

    <div class="fx-atmosphere" aria-hidden="true">
        <span class="a"></span>
        <span class="b"></span>
        <span class="c"></span>
    </div>

    <div class="edu-icon-cloud" aria-hidden="true">
        <i class="fa-solid fa-graduation-cap" style="left:7%; top:18%; font-size:46px; --rot:-16deg; --dur:16s;"></i>
        <i class="fa-solid fa-book" style="left:17%; top:73%; font-size:36px; --rot:8deg; --dur:19s; --delay:-2s;"></i>
        <i class="fa-solid fa-school" style="right:11%; top:20%; font-size:44px; --rot:-6deg; --dur:20s; --delay:-4s;"></i>
        <i class="fa-solid fa-ruler-combined" style="right:21%; top:77%; font-size:30px; --rot:24deg; --dur:14s; --delay:-3s;"></i>
        <i class="fa-solid fa-microscope" style="left:45%; top:11%; font-size:28px; --rot:6deg; --dur:17s; --delay:-5s;"></i>
    </div>

    <!-- Glow orbs -->
    <div class="glow-orb glow-1"></div>
    <div class="glow-orb glow-2"></div>

    <!-- Particle system -->
    <div class="particles" id="particleContainer"></div>

    <!-- Hero Content -->
    <div class="content-wrapper">
        <div class="hero-content fx-tilt">
            <div class="hero-logo"><i class="fa-solid fa-school-circle-check"></i></div>
            <h1 class="hero-title">SchoolHub</h1>
            <p class="hero-subtitle">Next Generation School Management System</p>
            <a href="{{ route('login') }}" class="login-button">
                <i class="fas fa-lock-open"></i> Start Now
            </a>
        </div>
    </div>
    <script src="{{ asset('js/unified-4d.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
