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
    <!-- Loader/Spinner Overlay -->
    <div id="preloader" class="preloader" style="display:none;">
        <div class="loader-stack">
            <div class="loader-grid">
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
                <div class="cube"></div>
            </div>
            <div class="loader-brand">Loading...</div>
        </div>
    </div>

@if($currentUser->role === 'superadmin')
<nav class="superadmin-navbar glass-4d-navbar navbar navbar-expand-lg p-0 mb-4">
    <div class="container-fluid align-items-stretch">
        <div class="d-flex flex-column align-items-start justify-content-center py-3 px-3" style="min-width:220px;">
            <img src="{{ asset('images/schoolhub-logo.svg') }}" alt="SchoolHub" class="navbar-logo mb-2" style="width:48px;">
            <div class="fw-bold fs-5">SchoolHub</div>
            <div class="mt-2">
                <span class="fw-semibold d-block">{{ $currentUser->name }}</span>
                <span class="badge bg-primary text-light">{{ ucfirst($currentUser->role) }}</span>
            </div>
        </div>
        <div class="flex-grow-1 d-flex flex-column flex-md-row align-items-center justify-content-between px-3">
            <div class="d-flex gap-3 flex-wrap my-2 my-md-0">
                <a href="{{ route('portal.index') }}" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="{{ route('portal.school') }}" class="nav-link"><i class="fa-solid fa-school"></i> Schools</a>
                <a href="{{ route('portal.school-admins.store') }}" class="nav-link"><i class="fa-solid fa-user-tie"></i> Admins</a>
                <a href="#calendarSection" class="nav-link"><i class="fa-solid fa-calendar-days"></i> Calendar</a>
                <a href="#workspaceSection" class="nav-link"><i class="fa-solid fa-briefcase"></i> Workspace</a>
            </div>
            <div class="d-flex align-items-center gap-3 ms-md-4">
                <button class="btn btn-link p-0" id="profileSettingsBtn" title="Profile & Settings" data-bs-toggle="modal" data-bs-target="#profileSettingsModal"><i class="fa-solid fa-user-gear"></i></button>
                <button class="btn btn-link p-0 position-relative" id="notificationBtn" title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display:none;">0</span>
                </button>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link p-0" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
                <button id="themeToggle" class="btn btn-link p-0" title="Toggle Theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
@endif

<!-- Profile/Settings Modal -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-labelledby="profileSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass">
            <div class="modal-header">
                <h5 class="modal-title" id="profileSettingsModalLabel">Profile & Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('portal.profile.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="profileName" name="name" value="{{ $currentUser->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="profileEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profileEmail" name="email" value="{{ $currentUser->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="profilePhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="profilePhone" name="phone" value="{{ $currentUser->phone }}">
                    </div>
                    <button type="submit" class="btn btn-brand w-100 mb-2">Update Profile</button>
                </form>
                <form method="POST" action="{{ route('portal.password.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="profilePassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="profilePassword" name="password">
                    </div>
                    <button type="submit" class="btn btn-outline-brand w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
    <section class="row g-3 mb-3" id="dashboard-overview">
        <div class="col-md-4">
            <div class="glass p-3 metric metric-teachers fade-up" style="animation-delay: 0.05s;">
                <p class="soft mb-1">Teachers</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['teachers'] }}">{{ $stats['teachers'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass p-3 metric metric-classes fade-up" style="animation-delay: 0.1s;">
                <p class="soft mb-1">Classes</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['classes'] }}">{{ $stats['classes'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass p-3 metric metric-students fade-up" style="animation-delay: 0.15s;">
                <p class="soft mb-1">Students</p>
                <h3 class="mb-0 metric-number" data-count="{{ $stats['students'] }}">{{ $stats['students'] }}</h3>
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

    <!-- Calendar Section -->
    <section id="calendarSection" class="glass p-3 p-lg-4 mb-4 fade-up">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0"><i class="fa-solid fa-calendar-days me-2"></i>Calendar</h2>
            <span class="soft">School events, holidays, and activities</span>
        </div>
        <div class="calendar-placeholder text-center py-5">
            <i class="fa-solid fa-calendar-days fa-2x mb-3"></i>
            <p class="soft">Calendar integration coming soon...</p>
        </div>
    </section>

    <!-- Workspace Section -->
    <section id="workspaceSection" class="glass p-3 p-lg-4 mb-4 fade-up">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 section-title mb-0"><i class="fa-solid fa-briefcase me-2"></i>Workspace</h2>
            <span class="soft">Manage files, reports, and school resources</span>
        </div>
        <div class="workspace-placeholder text-center py-5">
            <i class="fa-solid fa-briefcase fa-2x mb-3"></i>
            <p class="soft">Workspace integration coming soon...</p>
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

@if($currentUser->role === 'admin' && isset($schools) && count($schools) > 1)
    <section class="row g-4 mb-4">
        @foreach($schools as $school)
            <div class="col-md-6 col-lg-4">
                <div class="card glass p-3 h-100">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $school->logo_url ?? asset('images/default-school-logo.svg') }}" alt="Logo" class="rounded-circle me-3" style="width:56px; height:56px; object-fit:cover;">
                        <div>
                            <h5 class="mb-0">{{ $school->name }}</h5>
                        </div>
                    </div>
                    <div class="mb-2"><strong>Email:</strong> {{ $school->email }}</div>
                    <div class="mb-2"><strong>Contact:</strong> {{ $school->phone }}</div>
                    <a href="{{ route('portal.school', $school->_id) }}" class="btn btn-brand w-100 mt-2">Manage Workspace</a>
                </div>
            </div>
        @endforeach
    </section>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/portal.js') }}"></script>
</body>
</html>
