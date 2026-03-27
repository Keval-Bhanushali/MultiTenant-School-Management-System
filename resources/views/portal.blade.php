<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Multi-Tenant School Management Portal</title>
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/unified-4d.css') }}">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body class="fx-page">
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

<canvas id="dashboardCanvas" class="dashboard-canvas" aria-hidden="true"></canvas>

<div class="scene-layer" aria-hidden="true">
    <span class="orb one"></span>
    <span class="orb two"></span>
    <span class="orb three"></span>
</div>

<div class="edu-icon-cloud" aria-hidden="true">
    <i class="fa-solid fa-graduation-cap" style="left:7%; top:19%; font-size:40px; --rot:-16deg; --dur:17s;"></i>
    <i class="fa-solid fa-book-open-reader" style="left:21%; top:78%; font-size:34px; --rot:9deg; --dur:19s; --delay:-1.5s;"></i>
    <i class="fa-solid fa-school" style="right:10%; top:17%; font-size:42px; --rot:-6deg; --dur:21s; --delay:-3.8s;"></i>
    <i class="fa-solid fa-calculator" style="right:20%; top:79%; font-size:30px; --rot:22deg; --dur:15s; --delay:-2.6s;"></i>
    <i class="fa-solid fa-flask-vial" style="left:47%; top:9%; font-size:27px; --rot:6deg; --dur:16.5s; --delay:-5s;"></i>
</div>

<button id="mobileSidebarToggle" class="btn btn-brand mobile-sidebar-toggle">
    <i class="fa-solid fa-bars"></i>
    Menu
</button>

<div class="dashboard-shell">
    <aside id="dashboardSidebar" class="dashboard-sidebar fade-up" style="animation-delay: 0.05s;">
        <div class="sidebar-brand">
            <img src="{{ asset('images/schoolhub-logo.svg') }}" alt="SchoolHub">
            <div>
                <p class="sidebar-title">Dashboard Modules</p>
                <p class="sidebar-subtitle">{{ ucfirst($currentUser->role) }} Panel</p>
            </div>
        </div>

        <nav class="sidebar-nav" aria-label="Dashboard Sidebar Navigation">
            <p class="nav-section-label">Overview</p>
            <a href="#dashboard-overview"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
            <p class="nav-section-label">Workspace</p>
            <a href="{{ route('portal.school') }}"><i class="fa-solid fa-school"></i>School Workspace</a>
        </nav>
    </aside>

    <main class="dashboard-main">
    <section class="hero p-4 p-lg-5 mb-4 fade-up">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative" style="z-index:1;">
            <div>
                <img class="hero-logo mb-3" src="{{ asset('images/schoolhub-logo.svg') }}" alt="SchoolHub Logo">
                <h1 class="fw-bold mb-2">Multi-Tenant School Management Portal</h1>
                <p class="mb-3">Single-page management for Teachers, Classes, and Students with MongoDB storage and model relationships.</p>
                <p class="mb-2"><span class="badge text-bg-light">Logged in as: {{ $currentUser->role }}</span>
                    @if($currentUser->school_id)
                        <span class="badge text-bg-warning">School scoped</span>
                    @endif
                </p>
                <div class="d-flex gap-2 flex-wrap anchor-nav">
                    <a href="#dashboard-overview"><i class="fa-solid fa-chart-pie me-1"></i>Live Analytics</a>
                    <a href="{{ route('portal.school') }}"><i class="fa-solid fa-table-list me-1"></i>Open School Records</a>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="live-pill"><i class="fa-solid fa-circle me-1"></i>Live DB</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn theme-toggle"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
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
        <div id="dashboard-overview"></div>
        @if(in_array($currentUser->role, ['superadmin', 'admin']))
        <div class="col-md-4">
            <div class="glass p-3 metric metric-teachers fade-up" style="animation-delay: 0.05s;">
                <p class="soft mb-1">Teachers</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['teachers'] }}">0</h3>
            </div>
        </div>
        @endif
        @if(in_array($currentUser->role, ['superadmin', 'admin', 'staff', 'teacher']))
        <div class="col-md-4">
            <div class="glass p-3 metric metric-classes fade-up" style="animation-delay: 0.1s;">
                <p class="soft mb-1">Classes</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['classes'] }}">0</h3>
            </div>
        </div>
        @endif
        @if(in_array($currentUser->role, ['superadmin', 'admin', 'staff', 'teacher', 'student']))
        <div class="col-md-4">
            <div class="glass p-3 metric metric-students fade-up" style="animation-delay: 0.15s;">
                <p class="soft mb-1">Students</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['students'] }}">0</h3>
            </div>
        </div>
        @endif
    </section>
    <section class="row g-3 mb-4">
        @if(in_array($currentUser->role, ['superadmin', 'admin', 'staff', 'teacher']))
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
        @endif
        @if(in_array($currentUser->role, ['superadmin', 'admin']))
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
        @endif
        @if(in_array($currentUser->role, ['superadmin', 'admin', 'staff', 'teacher']))
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
        @endif
    </section>

    <section class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.3s;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h2 class="h4 section-title mb-0">Dashboard Focus Mode</h2>
            <span class="soft">Clean analytics-only dashboard</span>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-xl-4">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">School Records Workspace</h3>
                    <p class="soft mb-3">Manage schools, users, teachers, classes, students, files, and reports in a dedicated page.</p>
                    <a href="{{ route('portal.school') }}" class="btn btn-brand"><i class="fa-solid fa-arrow-right me-1"></i>Open Workspace</a>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">System Snapshot</h3>
                    <div class="d-flex justify-content-between mb-2"><span class="soft">Teachers</span><strong>{{ $stats['teachers'] }}</strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="soft">Classes</span><strong>{{ $stats['classes'] }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="soft">Students</span><strong>{{ $stats['students'] }}</strong></div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="p-3 rounded-3 border h-100">
                    <h3 class="h6 mb-2">Current Scope</h3>
                    <p class="soft mb-1">Role</p>
                    <p class="fw-semibold text-capitalize mb-2">{{ $currentUser->role }}</p>
                    <p class="soft mb-1">Tenant</p>
                    <p class="fw-semibold mb-0">{{ $currentUser->school_id ?: 'Global (Superadmin)' }}</p>
                </div>
            </div>
        </div>
    </section>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/portal.js') }}"></script>
</body>
</html>
