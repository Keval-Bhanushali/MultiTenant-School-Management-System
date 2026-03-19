<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Multi-Tenant School Management Portal</title>
    <link rel="shortcut icon" href="{{ asset('images/schoolhub-icon.ico') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f2f5ff;
            --card-bg: #ffffff;
            --text: #1b2440;
            --muted: #64748b;
            --line: #dbe3ff;
            --brand: #1d4ed8;
            --brand-2: #0891b2;
            --accent: #f59e0b;
            --shadow: 0 14px 40px rgba(29, 78, 216, 0.14);
        }

        html[data-theme='dark'] {
            --bg: #070b16;
            --card-bg: #0e1528;
            --text: #e9eefc;
            --muted: #95a2c7;
            --line: #273453;
            --brand: #60a5fa;
            --brand-2: #22d3ee;
            --accent: #fbbf24;
            --shadow: 0 16px 50px rgba(0, 0, 0, 0.45);
        }

        body {
            background: radial-gradient(circle at 10% 10%, rgba(34,211,238,0.22), transparent 40%),
                        radial-gradient(circle at 90% 20%, rgba(29,78,216,0.24), transparent 30%),
                        var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-family: "Poppins", "Segoe UI", sans-serif;
            overflow-x: hidden;
        }

        .preloader {
            position: fixed;
            inset: 0;
            background: linear-gradient(145deg, #0b1020, #14213d);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        .preloader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader-stack {
            perspective: 1000px;
            display: grid;
            justify-items: center;
            gap: 14px;
        }

        .loader-grid {
            display: grid;
            grid-template-columns: repeat(3, 20px);
            grid-template-rows: repeat(3, 20px);
            gap: 8px;
            transform-style: preserve-3d;
            transform: rotateX(54deg) rotateZ(44deg);
        }

        .cube {
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            border-radius: 4px;
            box-shadow: 0 6px 18px rgba(34, 211, 238, 0.28);
            animation: cubePulse 1.2s ease-in-out infinite;
        }

        .cube:nth-child(2), .cube:nth-child(4), .cube:nth-child(6), .cube:nth-child(8) {
            animation-delay: 0.12s;
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }

        .cube:nth-child(5) {
            animation-delay: 0.2s;
            background: linear-gradient(135deg, #a78bfa, #60a5fa);
        }

        .loader-brand {
            color: white;
            font-size: 0.76rem;
            letter-spacing: 0.22em;
            font-weight: 700;
            opacity: 0.92;
            animation: loaderText 1.2s ease-in-out infinite;
        }

        @keyframes cubePulse {
            0%, 100% { transform: translateZ(0) scale(1); opacity: 0.65; }
            50% { transform: translateZ(18px) scale(1.08); opacity: 1; }
        }

        @keyframes loaderText {
            0%, 100% { opacity: 0.65; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-2px); }
        }

        .scene-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(2px);
            opacity: 0.55;
            animation: floatOrb 12s ease-in-out infinite;
        }

        .orb.one {
            width: 240px;
            height: 240px;
            background: radial-gradient(circle at 30% 30%, #22d3ee, transparent 72%);
            top: 10%;
            left: -30px;
        }

        .orb.two {
            width: 280px;
            height: 280px;
            background: radial-gradient(circle at 30% 30%, #1d4ed8, transparent 75%);
            top: 56%;
            right: -50px;
            animation-delay: -3s;
        }

        .orb.three {
            width: 160px;
            height: 160px;
            background: radial-gradient(circle at 30% 30%, #f59e0b, transparent 72%);
            top: 75%;
            left: 26%;
            animation-delay: -6s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-28px) translateX(12px); }
        }

        .hero {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            color: white;
            border-radius: 1.25rem;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.2s ease;
        }

        .hero-logo {
            width: 220px;
            max-width: 46vw;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.35rem 0.65rem;
            box-shadow: 0 12px 30px rgba(0,0,0,0.22);
            transform: translateZ(18px);
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                60deg,
                rgba(255,255,255,0.0),
                rgba(255,255,255,0.0) 18px,
                rgba(255,255,255,0.06) 18px,
                rgba(255,255,255,0.06) 36px
            );
            pointer-events: none;
        }

        .glass {
            backdrop-filter: blur(8px);
            background: color-mix(in srgb, var(--card-bg) 84%, transparent);
            border: 1px solid var(--line);
            border-radius: 1rem;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .glass::before {
            content: '';
            position: absolute;
            inset: -80% auto auto -40%;
            width: 60%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(
                to right,
                rgba(255,255,255,0),
                rgba(255,255,255,0.14),
                rgba(255,255,255,0)
            );
            pointer-events: none;
            transition: transform 0.4s ease;
        }

        .glass:hover::before {
            transform: translateX(18%) rotate(22deg);
        }

        .glass:hover {
            box-shadow: 0 22px 52px rgba(29, 78, 216, 0.2);
        }

        .metric {
            transform-style: preserve-3d;
            transition: transform 0.25s ease;
        }

        .metric:hover {
            transform: translateY(-6px) rotateX(8deg) rotateY(-8deg);
        }

        .metric-number {
            font-size: 2.1rem;
            font-weight: 700;
            line-height: 1;
        }

        .metric-teachers:hover {
            box-shadow: 0 22px 52px rgba(8, 145, 178, 0.28);
            border-color: rgba(8, 145, 178, 0.35);
            color: #ffffff;
        }

        .metric-teachers:hover,
        .metric-teachers:hover * {
            color: #ffffff !important;
        }

        .metric-classes:hover {
            box-shadow: 0 22px 52px rgba(37, 99, 235, 0.28);
            border-color: rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .metric-classes:hover,
        .metric-classes:hover * {
            color: #ffffff !important;
        }

        .metric-students:hover {
            box-shadow: 0 22px 52px rgba(245, 158, 11, 0.28);
            border-color: rgba(245, 158, 11, 0.35);
            color: #ffffff;
        }

        .metric-students:hover,
        .metric-students:hover * {
            color: #ffffff !important;
        }

        .metric-teachers:hover .soft,
        .metric-classes:hover .soft,
        .metric-students:hover .soft {
            color: rgba(255, 255, 255, 0.92);
        }

        .chart-card {
            min-height: 175px;
            perspective: 1100px;
        }

        .chart-card:hover {
            transform: translateY(-6px) rotateX(4deg);
            box-shadow: 0 20px 44px rgba(29, 78, 216, 0.2);
        }

        .ring-chart {
            --deg: 0deg;
            width: 112px;
            height: 112px;
            border-radius: 50%;
            background: conic-gradient(var(--brand) var(--deg), color-mix(in srgb, var(--line) 75%, transparent) 0deg);
            display: grid;
            place-items: center;
            margin-inline: auto;
            transition: background 0.45s ease;
        }

        .ring-chart::before {
            content: '';
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: var(--card-bg);
            border: 1px solid var(--line);
        }

        .ring-center {
            position: absolute;
            font-weight: 700;
            font-size: 1rem;
        }

        .bars {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 110px;
            padding-inline: 6px;
        }

        .bar {
            flex: 1;
            border-radius: 8px 8px 4px 4px;
            background: linear-gradient(180deg, var(--brand-2), var(--brand));
            transform-origin: bottom;
            transform: scaleY(0.05);
            animation: growBar 1.1s ease forwards;
            animation-delay: var(--delay);
            box-shadow: inset 0 -10px 14px rgba(0,0,0,0.16);
        }

        @keyframes growBar {
            to { transform: scaleY(1); }
        }

        .pulse-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.6);
            animation: ping 1.6s infinite;
        }

        @keyframes ping {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.55); }
            70% { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        .spark-line {
            position: relative;
            height: 88px;
            border-radius: 12px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--brand) 17%, transparent), transparent 70%);
            overflow: hidden;
        }

        .spark-line svg {
            width: 100%;
            height: 100%;
        }

        .spark-line path.line {
            fill: none;
            stroke: var(--brand);
            stroke-width: 3;
            stroke-dasharray: 320;
            stroke-dashoffset: 320;
            animation: drawLine 1.5s ease forwards;
        }

        .spark-line path.area {
            fill: color-mix(in srgb, var(--brand) 20%, transparent);
            opacity: 0;
            animation: fadeArea 1.6s ease forwards;
            animation-delay: 0.4s;
        }

        @keyframes drawLine {
            to { stroke-dashoffset: 0; }
        }

        @keyframes fadeArea {
            to { opacity: 1; }
        }

        .module-card:hover {
            transform: translateY(-4px) rotateX(2deg);
        }

        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .soft {
            color: var(--muted);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text);
            --bs-table-border-color: var(--line);
        }

        .table thead th {
            color: var(--muted);
            border-bottom: 1px solid var(--line);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody tr {
            transition: transform 0.18s ease, background-color 0.18s ease;
        }

        .table tbody tr:hover {
            background: color-mix(in srgb, var(--brand) 8%, transparent);
            transform: translateX(4px);
        }

        .module-card {
            scroll-margin-top: 86px;
            border-left: 5px solid transparent;
        }

        .module-teachers:hover {
            border-left-color: #0891b2;
            box-shadow: 0 24px 54px rgba(8, 145, 178, 0.2);
            color: #ffffff;
        }

        .module-teachers:hover,
        .module-teachers:hover * {
            color: #ffffff !important;
        }

        .module-teachers:hover .section-title {
            color: #ffffff;
        }

        .module-classes:hover {
            border-left-color: #2563eb;
            box-shadow: 0 24px 54px rgba(37, 99, 235, 0.2);
            color: #ffffff;
        }

        .module-classes:hover,
        .module-classes:hover * {
            color: #ffffff !important;
        }

        .module-classes:hover .section-title {
            color: #ffffff;
        }

        .module-students:hover {
            border-left-color: #d97706;
            box-shadow: 0 24px 54px rgba(245, 158, 11, 0.2);
            color: #ffffff;
        }

        .module-students:hover,
        .module-students:hover * {
            color: #ffffff !important;
        }

        .module-students:hover .section-title {
            color: #ffffff;
        }

        .module-teachers:hover .soft,
        .module-classes:hover .soft,
        .module-students:hover .soft {
            color: rgba(255, 255, 255, 0.92);
        }

        html[data-theme='dark'] .metric-teachers:hover,
        html[data-theme='dark'] .metric-teachers:hover *,
        html[data-theme='dark'] .metric-classes:hover,
        html[data-theme='dark'] .metric-classes:hover *,
        html[data-theme='dark'] .metric-students:hover,
        html[data-theme='dark'] .metric-students:hover *,
        html[data-theme='dark'] .module-teachers:hover,
        html[data-theme='dark'] .module-teachers:hover *,
        html[data-theme='dark'] .module-classes:hover,
        html[data-theme='dark'] .module-classes:hover *,
        html[data-theme='dark'] .module-students:hover,
        html[data-theme='dark'] .module-students:hover *,
        html[data-theme='dark'] .module-teachers:hover .section-title,
        html[data-theme='dark'] .module-classes:hover .section-title,
        html[data-theme='dark'] .module-students:hover .section-title {
            color: #000000 !important;
        }

        html[data-theme='dark'] .metric-teachers:hover .soft,
        html[data-theme='dark'] .metric-classes:hover .soft,
        html[data-theme='dark'] .metric-students:hover .soft,
        html[data-theme='dark'] .module-teachers:hover .soft,
        html[data-theme='dark'] .module-classes:hover .soft,
        html[data-theme='dark'] .module-students:hover .soft {
            color: rgba(0, 0, 0, 0.8);
        }

        .anchor-nav a {
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
        }

        .anchor-nav a:hover {
            background: color-mix(in srgb, var(--text) 14%, transparent);
            color: var(--text);
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            border: 0;
            color: white;
        }

        .btn-brand:hover {
            opacity: 0.92;
            color: white;
        }

        .btn-brand.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .btn-brand.loading .btn-label {
            opacity: 0;
        }

        .btn-brand .btn-spinner {
            display: none;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255,255,255,0.45);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .btn-brand.loading .btn-spinner {
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert-success.enhanced {
            animation: popIn 0.45s ease;
            border-left: 5px solid #10b981;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.96) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .theme-toggle {
            border: 1px solid rgba(255,255,255,0.55);
            color: white;
            background: rgba(255,255,255,0.14);
        }

        .theme-toggle:hover {
            background: rgba(255,255,255,0.24);
            color: white;
        }

        .live-pill {
            background: rgba(16,185,129,0.2);
            color: #064e3b;
            border: 1px solid rgba(16,185,129,0.45);
            font-size: 0.78rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-weight: 700;
        }

        html[data-theme='dark'] .live-pill {
            color: #bbf7d0;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(12px);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .hero,
            .metric,
            .module-card {
                transform: none !important;
            }
        }
    </style>
</head>
<body>
<div id="pagePreloader" class="preloader" aria-hidden="true">
    <div class="loader-stack">
        <div class="loader-grid" aria-hidden="true">
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
            <span class="cube"></span>
        </div>
        <span class="loader-brand">SCHOOL</span>
    </div>
</div>

<div class="scene-layer" aria-hidden="true">
    <span class="orb one"></span>
    <span class="orb two"></span>
    <span class="orb three"></span>
</div>

<div class="container py-4 py-lg-5">
    <section class="hero p-4 p-lg-5 mb-4 fade-up">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative" style="z-index:1;">
            <div>
                <img class="hero-logo mb-3" src="{{ asset('images/schoolhub-logo.svg') }}" alt="SchoolHub Logo">
                <h1 class="fw-bold mb-2">Multi-Tenant School Management Portal</h1>
                <p class="mb-3">Single-page management for Teachers, Classes, and Students with MongoDB storage and model relationships.</p>
                <div class="d-flex gap-2 flex-wrap anchor-nav">
                    <a href="#teachers"><i class="fa-solid fa-chalkboard-user me-1"></i>Teachers</a>
                    <a href="#classes"><i class="fa-solid fa-door-open me-1"></i>Classes</a>
                    <a href="#students"><i class="fa-solid fa-user-graduate me-1"></i>Students</a>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="live-pill"><i class="fa-solid fa-circle me-1"></i>Live DB</span>
                <button id="themeToggle" class="btn theme-toggle">
                    <i class="fa-solid fa-moon me-1"></i>
                    <span>Dark</span>
                </button>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm enhanced"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="glass p-3 metric metric-teachers fade-up" style="animation-delay: 0.05s;">
                <p class="soft mb-1">Teachers</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['teachers'] }}">0</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass p-3 metric metric-classes fade-up" style="animation-delay: 0.1s;">
                <p class="soft mb-1">Classes</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['classes'] }}">0</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass p-3 metric metric-students fade-up" style="animation-delay: 0.15s;">
                <p class="soft mb-1">Students</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['students'] }}">0</h3>
            </div>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="glass chart-card p-3 p-lg-4 fade-up" style="animation-delay: 0.18s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 section-title mb-0">Attendance Health</h2>
                    <span class="pulse-dot"></span>
                </div>
                <div class="position-relative d-grid place-items-center">
                    <div class="ring-chart" id="attendanceRing"></div>
                    <span class="ring-center" id="attendanceRingValue">0%</span>
                </div>
                <p class="soft mt-3 mb-0 small">Live attendance trend this week.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass chart-card p-3 p-lg-4 fade-up" style="animation-delay: 0.22s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 section-title mb-0">Enrollment Pulse</h2>
                    <small class="soft">Last 6 months</small>
                </div>
                <div class="bars" aria-label="Enrollment bars">
                    <div class="bar" style="--delay: .05s; height: 32%;"></div>
                    <div class="bar" style="--delay: .12s; height: 45%;"></div>
                    <div class="bar" style="--delay: .19s; height: 60%;"></div>
                    <div class="bar" style="--delay: .26s; height: 54%;"></div>
                    <div class="bar" style="--delay: .33s; height: 76%;"></div>
                    <div class="bar" style="--delay: .40s; height: 88%;"></div>
                </div>
                <p class="soft mt-3 mb-0 small">Growth in student onboarding.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass chart-card p-3 p-lg-4 fade-up" style="animation-delay: 0.26s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 section-title mb-0">Engagement Flow</h2>
                    <small class="soft">Realtime</small>
                </div>
                <div class="spark-line">
                    <svg viewBox="0 0 320 90" preserveAspectRatio="none" role="img" aria-label="Engagement chart">
                        <path class="area" d="M0,90 L0,60 C24,44 48,48 74,40 C96,34 116,52 138,40 C168,22 190,18 216,34 C240,48 266,38 286,28 C304,20 314,26 320,24 L320,90 Z"></path>
                        <path class="line" d="M0,60 C24,44 48,48 74,40 C96,34 116,52 138,40 C168,22 190,18 216,34 C240,48 266,38 286,28 C304,20 314,26 320,24"></path>
                    </svg>
                </div>
                <p class="soft mt-3 mb-0 small">Activity intensity by module actions.</p>
            </div>
        </div>
    </section>

    <section id="teachers" class="module-card module-teachers glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.2s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Teacher Module</h2>
            <span class="soft">Relationship parent of classes</span>
        </div>
        <form class="row g-2 mb-3" action="{{ route('portal.teachers.store') }}" method="POST">
            @csrf
            <div class="col-md-4"><input name="name" class="form-control" placeholder="Teacher name" required></div>
            <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="col-md-2"><input name="phone" class="form-control" placeholder="Phone"></div>
            <div class="col-md-2"><input name="subject_specialization" class="form-control" placeholder="Subject" required></div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-brand js-submit-btn" type="submit">
                    <span class="btn-label">Add</span>
                    <span class="btn-spinner"></span>
                </button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone ?: '-' }}</td>
                            <td>{{ $teacher->subject_specialization }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="soft">No teachers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section id="classes" class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.25s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Class Module</h2>
            <span class="soft">Belongs to teacher, has many students</span>
        </div>
        <form class="row g-2 mb-3" action="{{ route('portal.classes.store') }}" method="POST">
            @csrf
            <div class="col-md-3"><input name="name" class="form-control" placeholder="Class name" required></div>
            <div class="col-md-2"><input name="section" class="form-control" placeholder="Section" required></div>
            <div class="col-md-2"><input type="number" min="1" name="capacity" class="form-control" placeholder="Capacity" required></div>
            <div class="col-md-3">
                <select name="teacher_id" class="form-select">
                    <option value="">Assign teacher (optional)</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->_id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1"><input name="room_number" class="form-control" placeholder="Room"></div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-brand js-submit-btn" type="submit">
                    <span class="btn-label">Add</span>
                    <span class="btn-spinner"></span>
                </button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Capacity</th>
                        <th>Teacher</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->section }}</td>
                            <td>{{ $class->capacity }}</td>
                            <td>{{ optional($class->teacher)->name ?: 'Unassigned' }}</td>
                            <td>{{ $class->room_number ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="soft">No classes yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section id="students" class="module-card module-students glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.3s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0">Student Module</h2>
            <span class="soft">Belongs to class</span>
        </div>
        <form class="row g-2 mb-3" action="{{ route('portal.students.store') }}" method="POST">
            @csrf
            <div class="col-md-3"><input name="name" class="form-control" placeholder="Student name" required></div>
            <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="col-md-2"><input name="roll_number" class="form-control" placeholder="Roll number" required></div>
            <div class="col-md-2">
                <select name="class_id" class="form-select" required>
                    <option value="">Select class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->_id }}">{{ $class->name }} - {{ $class->section }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1"><input name="guardian_name" class="form-control" placeholder="Guardian"></div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-brand js-submit-btn" type="submit">
                    <span class="btn-label">Add</span>
                    <span class="btn-spinner"></span>
                </button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roll</th>
                        <th>Class</th>
                        <th>Guardian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->roll_number }}</td>
                            <td>
                                @php($c = $student->schoolClass)
                                {{ $c ? $c->name . ' - ' . $c->section : 'Unknown' }}
                            </td>
                            <td>{{ $student->guardian_name ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="soft">No students yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const preloader = document.getElementById('pagePreloader');
        const root = document.documentElement;
        const toggle = document.getElementById('themeToggle');
        const icon = toggle.querySelector('i');
        const text = toggle.querySelector('span');
        const hero = document.querySelector('.hero');
        const tiltCards = document.querySelectorAll('.metric, .module-card');
        const statNodes = document.querySelectorAll('.metric-number');
        const ring = document.getElementById('attendanceRing');
        const ringValue = document.getElementById('attendanceRingValue');
        const forms = document.querySelectorAll('form');

        const apply = (theme) => {
            root.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun me-1';
                text.textContent = 'Light';
            } else {
                icon.className = 'fa-solid fa-moon me-1';
                text.textContent = 'Dark';
            }
        };

        const saved = localStorage.getItem('theme') || 'light';
        apply(saved);

        window.addEventListener('load', function () {
            setTimeout(function () {
                preloader.classList.add('hide');
            }, 350);
        });

        toggle.addEventListener('click', function () {
            const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            apply(next);
        });

        const animateCount = function (el) {
            const target = parseInt(el.getAttribute('data-count') || '0', 10);
            const duration = 1200;
            const start = performance.now();

            const tick = function (now) {
                const p = Math.min((now - start) / duration, 1);
                const val = Math.floor(target * (1 - Math.pow(1 - p, 3)));
                el.textContent = val.toLocaleString();
                if (p < 1) {
                    requestAnimationFrame(tick);
                }
            };

            requestAnimationFrame(tick);
        };

        statNodes.forEach(animateCount);

        const ringTarget = 92;
        let ringCurrent = 0;
        const ringTimer = setInterval(function () {
            ringCurrent += 2;
            if (ringCurrent > ringTarget) {
                ringCurrent = ringTarget;
                clearInterval(ringTimer);
            }
            if (ring && ringValue) {
                ring.style.setProperty('--deg', (ringCurrent * 3.6) + 'deg');
                ringValue.textContent = ringCurrent + '%';
            }
        }, 22);

        forms.forEach(function (form) {
            form.addEventListener('submit', function () {
                const btn = form.querySelector('.js-submit-btn');
                if (!btn) return;
                btn.classList.add('loading');
                setTimeout(function () {
                    btn.classList.remove('loading');
                }, 1800);
            });
        });

        const tilt = function (el, e) {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const midX = rect.width / 2;
            const midY = rect.height / 2;
            const rotateY = ((x - midX) / midX) * 4;
            const rotateX = -((y - midY) / midY) * 4;
            el.style.transform = 'perspective(900px) rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateY(-2px)';
        };

        const resetTilt = function (el) {
            el.style.transform = '';
        };

        if (window.innerWidth > 992) {
            if (hero) {
                hero.addEventListener('mousemove', function (e) {
                    tilt(hero, e);
                });
                hero.addEventListener('mouseleave', function () {
                    resetTilt(hero);
                });
            }

            tiltCards.forEach(function (card) {
                card.addEventListener('mousemove', function (e) {
                    tilt(card, e);
                });
                card.addEventListener('mouseleave', function () {
                    resetTilt(card);
                });
            });
        }
    })();
</script>
</body>
</html>
