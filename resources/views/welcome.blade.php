<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AuraCampus | Multitenant School OS</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen overflow-x-hidden text-slate-100 antialiased">
    <div class="pointer-events-none fixed inset-0 -z-20 overflow-hidden">
        <div class="mesh-orb one -left-32 -top-28 h-104 w-104"></div>
        <div class="mesh-orb two -right-28 top-32 h-96 w-96"></div>
        <div class="mesh-orb three -bottom-32 left-[38%] h-96 w-96"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.08),transparent_35%),linear-gradient(135deg,rgba(15,23,42,0.86),rgba(2,6,23,0.96))]"></div>
        <canvas data-particle-field class="absolute inset-0 h-full w-full opacity-70"></canvas>
    </div>

    <div data-global-loader class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 opacity-0 transition-opacity duration-300">
        <div class="glass-card flex items-center gap-3 px-5 py-4 text-sm font-medium">
            <span class="h-3 w-3 animate-pulse rounded-full bg-cyan-300 shadow-[0_0_24px_rgba(34,211,238,0.9)]"></span>
            Preparing AuraCampus...
        </div>
    </div>

    <header class="relative z-10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="#top" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/10 backdrop-blur-xl shadow-lg shadow-indigo-500/20">
                    <svg viewBox="0 0 24 24" class="h-7 w-7 drop-shadow-[0_6px_14px_rgba(99,102,241,0.55)]" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 6.5L12 3l8 3.5L12 10 4 6.5Z" stroke-linejoin="round"></path>
                        <path d="M4 6.5V17l8 4 8-4V6.5" stroke-linejoin="round"></path>
                        <path d="M12 10v11" stroke-linecap="round"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-[0.2em] text-white uppercase">AuraCampus</p>
                    <p class="text-xs text-slate-300">Multitenant School Operating System</p>
                </div>
            </a>
            <div class="hidden items-center gap-3 md:flex">
                <a href="#pricing" class="glass-button-secondary text-sm">Pricing</a>
                <a href="{{ route('login') }}" class="glass-button text-sm" data-load-transition="true">Login</a>
            </div>
        </div>
    </header>

    <main id="top" class="relative z-10">
        <section class="mx-auto grid max-w-7xl gap-10 px-4 pb-14 pt-8 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-20 lg:pt-12">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium uppercase tracking-[0.24em] text-slate-200 backdrop-blur-2xl">
                    <span class="h-2 w-2 rounded-full bg-cyan-300 shadow-[0_0_18px_rgba(34,211,238,0.95)]"></span>
                    Built for tenants, schools, parents, staff
                </div>

                <div class="space-y-5">
                    <h1 class="max-w-3xl text-5xl font-semibold tracking-tight text-white sm:text-6xl lg:text-7xl">
                        The school OS with a premium glass interface and real multitenant depth.
                    </h1>
                    <p class="max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                        AuraCampus unifies admissions, classes, finance, communication, wallets, documents, and analytics in one connected platform designed for web, mobile, and Capacitor shells.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('login') }}" class="glass-button" data-load-transition="true">
                        Access Platform
                        <svg viewBox="0 0 20 20" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 10h12m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </a>
                    <a href="#pricing" class="glass-button-secondary">View Pricing</a>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Tenants</p>
                        <p class="mt-2 text-3xl font-semibold text-white">99.99%</p>
                        <p class="mt-1 text-sm text-slate-400">Isolated workspace architecture</p>
                    </div>
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Payments</p>
                        <p class="mt-2 text-3xl font-semibold text-white">Stripe</p>
                        <p class="mt-1 text-sm text-slate-400">Fee and wallet automation</p>
                    </div>
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Mobile</p>
                        <p class="mt-2 text-3xl font-semibold text-white">Capacitor</p>
                        <p class="mt-1 text-sm text-slate-400">Android and iOS ready shell</p>
                    </div>
                </div>
            </div>

            <div class="relative min-h-152 lg:min-h-176">
                <div class="floating-panel left-2 top-8 h-56 w-[82%] rounded-4xl p-4 animate-floaty sm:left-8 sm:h-64 sm:w-[78%]" style="transform: perspective(1200px) rotateY(-18deg) rotateX(6deg);">
                    <div class="flex items-center justify-between border-b border-white/10 pb-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Desktop Dashboard</p>
                            <p class="text-lg font-semibold text-white">Command Center</p>
                        </div>
                        <span class="rounded-full border border-emerald-300/25 bg-emerald-500/15 px-3 py-1 text-xs text-emerald-200">Live</span>
                    </div>
                    <div class="mt-4 grid grid-cols-3 gap-3">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-3">
                            <p class="text-[11px] text-slate-300">Revenue</p>
                            <p class="mt-1 text-xl font-semibold text-white">$48.2K</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-3">
                            <p class="text-[11px] text-slate-300">Tenants</p>
                            <p class="mt-1 text-xl font-semibold text-white">128</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-3">
                            <p class="text-[11px] text-slate-300">Attendance</p>
                            <p class="mt-1 text-xl font-semibold text-white">96%</p>
                        </div>
                    </div>
                    <div class="mt-4 h-24 rounded-2xl border border-cyan-400/20 bg-[linear-gradient(135deg,rgba(34,211,238,0.2),rgba(99,102,241,0.15))] p-4">
                        <div class="flex h-full items-end gap-2">
                            <span class="h-[42%] w-3 rounded-full bg-cyan-300/90"></span>
                            <span class="h-[58%] w-3 rounded-full bg-cyan-300/80"></span>
                            <span class="h-[74%] w-3 rounded-full bg-cyan-300/70"></span>
                            <span class="h-[63%] w-3 rounded-full bg-cyan-300/90"></span>
                            <span class="h-[86%] w-3 rounded-full bg-cyan-300"></span>
                            <span class="h-[79%] w-3 rounded-full bg-cyan-300/80"></span>
                        </div>
                    </div>
                </div>

                <div class="floating-panel right-3 top-52 h-64 w-[76%] rounded-4xl p-4 animate-floaty sm:right-8 sm:h-72 sm:w-[72%]" style="animation-delay: -3s; transform: perspective(1200px) rotateY(16deg) rotateX(-5deg);">
                    <div class="flex items-center justify-between border-b border-white/10 pb-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-fuchsia-200">Mobile App</p>
                            <p class="text-lg font-semibold text-white">Parent Portal</p>
                        </div>
                        <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs text-slate-200">iOS / Android</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="rounded-2xl border border-white/10 bg-black/10 p-3">
                            <p class="text-xs text-slate-300">Balance</p>
                            <p class="mt-1 text-2xl font-semibold text-white">₹4,280</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-white/10 bg-white/10 p-3">
                                <p class="text-xs text-slate-300">AI Attendance</p>
                                <p class="mt-1 text-sm text-cyan-200">Camera, Bluetooth, GPS</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/10 p-3">
                                <p class="text-xs text-slate-300">Wallet</p>
                                <p class="mt-1 text-sm text-cyan-200">QR / NFC payments</p>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-emerald-300/20 bg-emerald-500/10 p-3 text-sm text-emerald-100">
                            Connected campus sync active.
                        </div>
                    </div>
                </div>

                <div class="floating-panel bottom-3 left-[18%] h-28 w-[58%] rounded-[1.6rem] p-4 sm:left-[12%] sm:h-32 sm:w-[54%] animate-breathe" style="animation-delay: -6s; transform: perspective(1200px) rotateX(18deg);">
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-300">Cross Platform</p>
                    <p class="mt-2 text-sm text-white/90">One codebase. Web, mobile shell, and admin portals in one system.</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            <div class="section-shell p-6 sm:p-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-cyan-200">Product Stack</p>
                        <h2 class="mt-2 text-3xl font-semibold text-white">A connected suite for every school role.</h2>
                    </div>
                    <p class="max-w-2xl text-sm leading-7 text-slate-300">Admissions, classrooms, finance, documents, analytics, communication, mobile hardware bridges, and SaaS billing share a single tenant-aware foundation.</p>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Finance</p>
                        <p class="mt-2 text-lg font-semibold">Stripe & Razorpay</p>
                        <p class="mt-2 text-sm text-slate-400">Fees, subscriptions, wallet top-ups, payroll.</p>
                    </div>
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Communication</p>
                        <p class="mt-2 text-lg font-semibold">Auto-translation notices</p>
                        <p class="mt-2 text-sm text-slate-400">WhatsApp and email stubs for parents.</p>
                    </div>
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Academics</p>
                        <p class="mt-2 text-lg font-semibold">Predictive analytics</p>
                        <p class="mt-2 text-sm text-slate-400">Flag at-risk students from attendance and scores.</p>
                    </div>
                    <div class="glass-card p-5">
                        <p class="text-sm text-slate-300">Realtime</p>
                        <p class="mt-2 text-lg font-semibold">GPS / WebRTC / Bluetooth</p>
                        <p class="mt-2 text-sm text-slate-400">Bus tracking, live classes, proximity check-ins.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="pricing" class="mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8">
            <div class="section-shell p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-fuchsia-200">Pricing</p>
                        <h2 class="mt-2 text-3xl font-semibold text-white">Choose a plan that scales with your campus.</h2>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 p-1 backdrop-blur-2xl">
                        <button id="monthlyToggle" class="rounded-full px-4 py-2 text-sm font-medium text-white transition data-[active=true]:bg-white/15" data-active="true" type="button">Monthly</button>
                        <button id="yearlyToggle" class="rounded-full px-4 py-2 text-sm font-medium text-slate-300 transition" type="button">Yearly</button>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 lg:grid-cols-3">
                    <article class="glass-card p-6">
                        <p class="text-sm uppercase tracking-[0.18em] text-cyan-200">Starter</p>
                        <div class="mt-4 flex items-end gap-2">
                            <span class="text-5xl font-semibold text-white" data-price-monthly="Starter">$29</span>
                            <span class="pb-1 text-sm text-slate-300" data-price-unit>/mo</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-300" data-price-note="Starter">Ideal for a single school launch.</p>
                        <ul class="mt-6 space-y-3 text-sm text-slate-200">
                            <li>Unified portal and attendance</li>
                            <li>Notices and documents</li>
                            <li>Basic analytics</li>
                        </ul>
                    </article>
                    <article class="glass-card border-cyan-300/30 p-6 shadow-[0_30px_90px_rgba(34,211,238,0.16)]">
                        <p class="text-sm uppercase tracking-[0.18em] text-fuchsia-200">Growth</p>
                        <div class="mt-4 flex items-end gap-2">
                            <span class="text-5xl font-semibold text-white" data-price-monthly="Growth">$79</span>
                            <span class="pb-1 text-sm text-slate-300" data-price-unit>/mo</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-300" data-price-note="Growth">For multi-campus teams with finance workflows.</p>
                        <ul class="mt-6 space-y-3 text-sm text-slate-200">
                            <li>Wallet and fee automation</li>
                            <li>Payroll and document vault</li>
                            <li>Mobile hardware bridges</li>
                        </ul>
                    </article>
                    <article class="glass-card p-6">
                        <p class="text-sm uppercase tracking-[0.18em] text-emerald-200">Enterprise</p>
                        <div class="mt-4 flex items-end gap-2">
                            <span class="text-5xl font-semibold text-white" data-price-monthly="Enterprise">$199</span>
                            <span class="pb-1 text-sm text-slate-300" data-price-unit>/mo</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-300" data-price-note="Enterprise">High-scale district and chain-school deployment.</p>
                        <ul class="mt-6 space-y-3 text-sm text-slate-200">
                            <li>White-label tenant architecture</li>
                            <li>AI analytics and realtime modules</li>
                            <li>Dedicated onboarding and support</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <script>
        window.__AURACAMPUS_PRICING__ = {
            monthly: {
                Starter: '$29',
                Growth: '$79',
                Enterprise: '$199',
                note: '/mo',
            },
            yearly: {
                Starter: '$290',
                Growth: '$790',
                Enterprise: '$1,990',
                note: '/yr',
            },
        };
    </script>
</body>
</html>