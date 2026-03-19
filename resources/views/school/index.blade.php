<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>School Workspace | Multi-Tenant School Management</title>
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
            <span class="cube"></span><span class="cube"></span><span class="cube"></span>
            <span class="cube"></span><span class="cube"></span><span class="cube"></span>
            <span class="cube"></span><span class="cube"></span><span class="cube"></span>
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
    <i class="fa-solid fa-graduation-cap" style="left:7%; top:20%; font-size:40px; --rot:-16deg; --dur:17s;"></i>
    <i class="fa-solid fa-book-open-reader" style="left:21%; top:79%; font-size:34px; --rot:9deg; --dur:19s; --delay:-1.5s;"></i>
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
                <p class="sidebar-title">School Workspace</p>
                <p class="sidebar-subtitle">{{ ucfirst($currentUser->role) }} View</p>
            </div>
        </div>

        <nav class="sidebar-nav" aria-label="School Workspace Navigation">
            <p class="nav-section-label">Main</p>
            <a href="{{ route('portal.index') }}"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
            <a href="#school-summary"><i class="fa-solid fa-school"></i>Summary</a>

            <p class="nav-section-label">Records</p>
            <a href="#teachers-records"><i class="fa-solid fa-chalkboard-user"></i>Teachers</a>
            <a href="#classes-records"><i class="fa-solid fa-door-open"></i>Classes</a>
            <a href="#students-records"><i class="fa-solid fa-user-graduate"></i>Students</a>
            <a href="#academics-records"><i class="fa-solid fa-book-open"></i>Academics</a>
        </nav>
    </aside>

    <main class="dashboard-main">
        <section class="hero p-4 p-lg-5 mb-4 fade-up">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative" style="z-index:1;">
                <div>
                    <img class="hero-logo mb-3" src="{{ asset('images/schoolhub-logo.svg') }}" alt="SchoolHub Logo">
                    <h1 class="fw-bold mb-2">School Records Workspace</h1>
                    <p class="mb-3">Clean, table-focused records view for school data. Dashboard remains analytics-only.</p>
                    <div class="d-flex gap-2 flex-wrap anchor-nav">
                        <a href="#teachers-records"><i class="fa-solid fa-chalkboard-user me-1"></i>Teachers</a>
                        <a href="#classes-records"><i class="fa-solid fa-door-open me-1"></i>Classes</a>
                        <a href="#students-records"><i class="fa-solid fa-user-graduate me-1"></i>Students</a>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('portal.index') }}" class="btn theme-toggle"><i class="fa-solid fa-arrow-left"></i></a>
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

        <section id="school-summary" class="row g-3 mb-4">
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

        <section id="teachers-records" class="module-card module-teachers glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.2s;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 section-title mb-0">Teachers</h2>
                <span class="soft">{{ $teachers->count() }} records</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr><th>Name</th><th>Email</th><th>Phone</th><th>Specialization</th></tr>
                    </thead>
                    <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone ?: '-' }}</td>
                            <td>{{ $teacher->subject_specialization ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="soft">No teacher records found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section id="classes-records" class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.24s;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 section-title mb-0">Classes</h2>
                <span class="soft">{{ $classes->count() }} records</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr><th>Class</th><th>Section</th><th>Capacity</th><th>Teacher</th><th>Room</th></tr>
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
                        <tr><td colspan="5" class="soft">No class records found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section id="students-records" class="module-card module-students glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.28s;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 section-title mb-0">Students</h2>
                <span class="soft">{{ $students->count() }} records</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr><th>Name</th><th>Email</th><th>Roll</th><th>Class</th><th>Guardian</th></tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->roll_number }}</td>
                            <td>@php($c = $student->schoolClass){{ $c ? $c->name . ' - ' . $c->section : 'Unknown' }}</td>
                            <td>{{ $student->guardian_name ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="soft">No student records found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section id="academics-records" class="module-card module-classes glass p-3 p-lg-4 mb-4 fade-up" style="animation-delay: 0.32s;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 section-title mb-0">Academic Structure</h2>
                <span class="soft">Standards and subjects</span>
            </div>
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead><tr><th>Standard</th><th>Order</th><th>Status</th></tr></thead>
                            <tbody>
                            @forelse($standards as $standard)
                                <tr><td>{{ $standard->name }}</td><td>{{ $standard->order }}</td><td>{{ $standard->status ?: '-' }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="soft">No standards found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead><tr><th>Subject</th><th>Code</th></tr></thead>
                            <tbody>
                            @forelse($subjects as $subject)
                                <tr><td>{{ $subject->name }}</td><td>{{ $subject->code ?: '-' }}</td></tr>
                            @empty
                                <tr><td colspan="2" class="soft">No subjects found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
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
