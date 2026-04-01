<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Login | AuraCampus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/unified-4d.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="fx-page min-h-screen text-slate-100">
    <div class="fixed inset-0 -z-20 overflow-hidden pointer-events-none">
        <div class="mesh-orb one" style="left:-8rem; top:-6rem; width:24rem; height:24rem;"></div>
        <div class="mesh-orb two" style="right:4rem; top:8rem; width:18rem; height:18rem;"></div>
        <div class="mesh-orb three" style="left:40%; bottom:-5rem; width:20rem; height:20rem;"></div>
    </div>

    <main class="mx-auto grid min-h-screen max-w-7xl items-center gap-10 px-4 py-10 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
        <section class="relative overflow-hidden rounded-4xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/50 backdrop-blur-2xl lg:p-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.16),transparent_40%),radial-gradient(circle_at_bottom_right,rgba(99,102,241,0.16),transparent_35%)]"></div>
            <div class="relative">
                <div class="mb-8 inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.3em] text-cyan-100">
                    <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                    AuraCampus Secure Portal
                </div>

                <h1 class="max-w-2xl text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                    One login for the full school operating system.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                    Enter the multitenant workspace for superadmins, admins, staff, teachers, and students with a single secure sign-in.
                </p>

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Access</p>
                        <p class="mt-2 text-lg font-semibold text-white">Role-aware</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Security</p>
                        <p class="mt-2 text-lg font-semibold text-white">Session guarded</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">UI</p>
                        <p class="mt-2 text-lg font-semibold text-white">Glassmorphic</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="glass-card p-6 sm:p-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/schoolhub-logo.svg') }}" alt="AuraCampus" class="h-14 w-14 rounded-2xl">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-cyan-200">AuraCampus</p>
                    <h2 class="text-2xl font-semibold text-white">Sign in</h2>
                </div>
            </div>

            <p class="mt-4 text-sm text-slate-300">Use your school account to continue.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-400/20 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
                    {{ $errors->first() ?? 'Invalid credentials. Please try again.' }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" id="loginForm" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-200" for="email">Email address</label>
                    <input
                        type="email"
                        class="glass-input @error('email') ring-2 ring-rose-400/50 @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-200" for="password">Password</label>
                    <input
                        type="password"
                        class="glass-input @error('password') ring-2 ring-rose-400/50 @enderror"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="glass-button w-full" id="loginBtn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Sign in
                </button>
            </form>

            <div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                <strong class="block text-white">Role-based login</strong>
                superadmin, admin, staff, teacher, student, parent, alumni
            </div>
        </section>
    </main>

    <script src="{{ asset('js/unified-4d.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
