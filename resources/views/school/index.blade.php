@extends('layouts.MainLayout', ['title' => 'School Workspace', 'pageTitle' => 'School Workspace'])

@section('content')
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
            <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Workspace Role</p>
            <p class="mt-3 text-2xl font-semibold capitalize text-white">{{ $currentUser->role }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <section class="glass-card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Teachers</h2>
                <span class="text-xs text-slate-300">{{ $teachers->count() }} records</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-left text-slate-300">
                            <th class="py-2 pr-3">Name</th>
                            <th class="py-2 pr-3">Email</th>
                            <th class="py-2 pr-3">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers->take(8) as $teacher)
                            <tr class="border-b border-white/5">
                                <td class="py-2 pr-3">{{ $teacher->name }}</td>
                                <td class="py-2 pr-3">{{ $teacher->email }}</td>
                                <td class="py-2 pr-3">{{ $teacher->phone ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-slate-300">No teachers available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="glass-card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Students</h2>
                <span class="text-xs text-slate-300">{{ $students->count() }} records</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-left text-slate-300">
                            <th class="py-2 pr-3">Name</th>
                            <th class="py-2 pr-3">Roll</th>
                            <th class="py-2 pr-3">Guardian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students->take(8) as $student)
                            <tr class="border-b border-white/5">
                                <td class="py-2 pr-3">{{ $student->name }}</td>
                                <td class="py-2 pr-3">{{ $student->roll_number }}</td>
                                <td class="py-2 pr-3">{{ $student->guardian_name ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-slate-300">No students available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <section class="glass-card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Classes</h2>
                <span class="text-xs text-slate-300">{{ $classes->count() }} records</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-left text-slate-300">
                            <th class="py-2 pr-3">Class</th>
                            <th class="py-2 pr-3">Section</th>
                            <th class="py-2 pr-3">Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes->take(8) as $class)
                            <tr class="border-b border-white/5">
                                <td class="py-2 pr-3">{{ $class->name }}</td>
                                <td class="py-2 pr-3">{{ $class->section }}</td>
                                <td class="py-2 pr-3">{{ $class->capacity }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-slate-300">No classes available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="glass-card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Academic Structure</h2>
                <span class="text-xs text-slate-300">{{ $standards->count() }} standards</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-left text-slate-300">
                            <th class="py-2 pr-3">Standard</th>
                            <th class="py-2 pr-3">Order</th>
                            <th class="py-2 pr-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standards->take(8) as $standard)
                            <tr class="border-b border-white/5">
                                <td class="py-2 pr-3">{{ $standard->name }}</td>
                                <td class="py-2 pr-3">{{ $standard->order }}</td>
                                <td class="py-2 pr-3">{{ $standard->status ?: 'active' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-slate-300">No standards available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('resources.teachers.index') }}" class="glass-button-secondary justify-center">Manage Teachers</a>
        <a href="{{ route('resources.students.index') }}" class="glass-button-secondary justify-center">Manage Students</a>
        <a href="{{ route('resources.attendance.index') }}" class="glass-button-secondary justify-center">Manage Attendance</a>
        <a href="{{ route('resources.notices.index') }}" class="glass-button-secondary justify-center">Manage Notices</a>
    </div>
@endsection
