@extends('modules.layout', ['title' => 'Calendar & Recurring Engine'])

@section('content')
<div class="grid gap-6">
    @include('modules.shared.list', [
        'heading' => 'Schedules',
        'subheading' => 'Exam timetables and school events',
        'createRoute' => route('modules.calendar.create'),
        'columns' => ['Name', 'Date', 'Status'],
        'rows' => $schedules,
        'rowRenderer' => function($row) { return [$row->name, $row->date, $row->status ?? 'active']; },
        'routeBase' => 'modules.calendar',
    ])

    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
        <div class="mb-5">
            <h2 class="text-2xl font-semibold">Recurring Tasks</h2>
            <p class="text-sm text-slate-300">Attendance reminders, invoice jobs and automation.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10 text-left text-slate-300">
                        <th class="py-3 pr-4 font-medium">Task</th>
                        <th class="py-3 pr-4 font-medium">Frequency</th>
                        <th class="py-3 pr-4 font-medium">Active</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr class="border-b border-white/5">
                            <td class="py-4 pr-4">{{ $task->task_name }}</td>
                            <td class="py-4 pr-4">{{ $task->frequency }}</td>
                            <td class="py-4 pr-4">{{ $task->is_active ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-5 text-slate-300">No recurring tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
