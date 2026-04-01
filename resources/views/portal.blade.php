@extends('layouts.MainLayout', ['title' => 'AuraCampus Portal', 'pageTitle' => 'Tenant Portal Overview'])

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-300/30 bg-emerald-500/20 px-4 py-3 text-sm">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-xl border border-rose-300/30 bg-rose-500/20 px-4 py-3 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="glass-card p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Teachers</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $stats['teachers'] }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Classes</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $stats['classes'] }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Students</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $stats['students'] }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Current Role</p>
            <p class="mt-3 text-2xl font-semibold capitalize text-white">{{ $currentUser->role }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="glass-card p-6 lg:col-span-2">
            <h2 class="text-xl font-semibold text-white">Workspace Shortcuts</h2>
            <p class="mt-1 text-sm text-slate-300">Quick access to the core records and operational modules.</p>
            <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                <a href="{{ route('portal.school') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">School Workspace</a>
                <a href="{{ route('resources.schools.index') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">Schools CRUD</a>
                <a href="{{ route('resources.teachers.index') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">Teachers CRUD</a>
                <a href="{{ route('resources.students.index') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">Students CRUD</a>
                <a href="{{ route('resources.staff-members.index') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">Staff CRUD</a>
                <a href="{{ route('resources.notices.index') }}" class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm transition hover:bg-white/15">Notices CRUD</a>
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="text-xl font-semibold text-white">Profile</h2>
            <p class="mt-1 text-sm text-slate-300">Update basic account information.</p>

            <form method="POST" action="{{ route('portal.profile.update') }}" class="mt-4 space-y-3">
                @csrf
                <input type="text" name="name" value="{{ $currentUser->name }}" class="glass-input" placeholder="Name">
                <input type="email" name="email" value="{{ $currentUser->email }}" class="glass-input" placeholder="Email">
                <input type="text" name="phone" value="{{ $currentUser->phone }}" class="glass-input" placeholder="Phone">
                <button type="submit" class="glass-button w-full">Save Profile</button>
            </form>
        </div>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white">Latest Notices</h2>
            <div class="mt-4 space-y-3">
                @forelse($notices->take(5) as $notice)
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <p class="text-sm font-semibold text-white">{{ $notice->title }}</p>
                        <p class="mt-1 text-xs text-slate-300">{{ \Illuminate\Support\Str::limit($notice->message, 90) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-300">No notices available.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold text-white">Upcoming Holidays</h2>
            <div class="mt-4 space-y-3">
                @forelse($holidays->take(5) as $holiday)
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <p class="text-sm font-semibold text-white">{{ $holiday->title }}</p>
                        <p class="mt-1 text-xs text-slate-300">{{ $holiday->date }} • {{ $holiday->type }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-300">No holidays planned yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
