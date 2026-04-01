<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'AuraCampus' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed relative min-h-screen overflow-x-hidden bg-slate-950 text-slate-100">
    <div class="pointer-events-none fixed inset-0 -z-20 overflow-hidden">
        <div class="mesh-orb one" style="left:-8rem; top:-8rem; width:28rem; height:28rem;"></div>
        <div class="mesh-orb two" style="right:-4rem; top:4rem; width:24rem; height:24rem;"></div>
        <div class="mesh-orb three" style="left:32%; bottom:-8rem; width:26rem; height:26rem;"></div>
        <div class="absolute inset-0 bg-[linear-gradient(130deg,rgba(2,6,23,0.96),rgba(15,23,42,0.92),rgba(3,7,18,0.96))]"></div>
        <canvas data-particle-field class="absolute inset-0 h-full w-full opacity-70"></canvas>
    </div>

    <div data-global-loader class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center bg-slate-950/35 opacity-0 transition-opacity duration-300">
        <div class="glass-card flex items-center gap-3 px-6 py-4 text-sm font-medium">
            <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-cyan-300 shadow-[0_0_18px_rgba(34,211,238,0.9)]"></span>
            Syncing AuraCampus workspace...
        </div>
    </div>

    <div class="wrapper relative z-10 min-h-screen">
        <nav class="main-header navbar navbar-expand navbar-dark border-0 bg-slate-950/70 backdrop-blur-2xl shadow-none">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <form class="form-inline ml-3 hidden md:block flex-1" action="#" method="GET">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar rounded-xl border border-white/15 bg-white/10 text-white placeholder:text-slate-300" type="search" placeholder="Search students, schools, modules..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar bg-white/10 text-white" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <ul class="navbar-nav ml-auto items-center gap-1">
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link text-slate-200">{{ now()->format('D, d M Y') }}</span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg rounded-xl border border-white/10 bg-slate-900/95 p-0 text-white">
                        <span class="dropdown-item dropdown-header bg-transparent text-slate-200">Notifications</span>
                        <div class="dropdown-divider border-white/10"></div>
                        <span class="dropdown-item text-sm text-slate-300">No new platform alerts</span>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right rounded-xl border border-white/10 bg-slate-900/95 p-2 text-white">
                        <div class="px-3 py-2 text-sm">
                            <div class="font-semibold">{{ auth()->user()->name ?? 'AuraCampus User' }}</div>
                            <div class="text-slate-300">{{ auth()->user()->role ?? 'workspace' }}</div>
                        </div>
                        <div class="dropdown-divider border-white/10"></div>
                        <a href="{{ route('portal.school') }}" class="dropdown-item rounded-lg px-3 py-2 text-sm text-white hover:bg-white/10">Workspace</a>
                        <a href="{{ route('portal.index') }}" class="dropdown-item rounded-lg px-3 py-2 text-sm text-white hover:bg-white/10">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-lg px-3 py-2 text-sm text-rose-200 hover:bg-rose-500/20">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-slate-950/90 backdrop-blur-2xl">
            <a href="{{ route('portal.index') }}" class="brand-link border-0 bg-transparent">
                <img src="{{ asset('images/schoolhub-logo.svg') }}" alt="AuraCampus" class="brand-image img-circle elevation-3" style="opacity:.95">
                <span class="brand-text font-weight-light text-white">AuraCampus</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-white/10">
                    <div class="image">
                        <img src="{{ asset('images/schoolhub-logo.svg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info text-white">
                        <a href="#" class="d-block text-white">{{ auth()->user()->name ?? 'Admin' }}</a>
                        <small class="text-slate-300 capitalize">{{ auth()->user()->role ?? 'workspace' }}</small>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('portal.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('portal.school') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Workspace</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resources.notices.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>Notices</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('modules.wallet.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Wallet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('modules.calendar.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-calendar-days"></i>
                                <p>Calendar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('modules.analytics.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Analytics</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper bg-transparent">
            <section class="content-header px-4 pt-4 sm:px-6 lg:px-8">
                <div class="container-fluid p-0">
                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-3xl border border-white/10 bg-white/5 px-5 py-4 backdrop-blur-2xl">
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-cyan-200">Platform Control Layer</p>
                            <h1 class="text-2xl font-semibold text-white">{{ $pageTitle ?? 'AuraCampus Command Center' }}</h1>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs text-slate-200">Unified shell</span>
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs text-slate-200">Search enabled</span>
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs text-slate-200">Profile ready</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content px-4 pb-6 sm:px-6 lg:px-8">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
