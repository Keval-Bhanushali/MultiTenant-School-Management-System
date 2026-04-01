<?php

namespace App\Http\Controllers\Modules\Calendar;

use App\Http\Controllers\Controller;
use App\Models\RecurringTask;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $schedules = Schedule::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(10, ['*'], 'schedules');
        $tasks = RecurringTask::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(10, ['*'], 'tasks');
        return view('modules.calendar.index', compact('schedules', 'tasks'));
    }

    public function create()
    {
        return view('modules.calendar.create');
    }

    public function show(string $id)
    {
        $schedule = Schedule::query()->findOrFail($id);
        return view('modules.calendar.show', compact('schedule'));
    }

    public function edit(string $id)
    {
        $schedule = Schedule::query()->findOrFail($id);
        return view('modules.calendar.edit', compact('schedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'date' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        Schedule::query()->create($validated);
        return redirect()->route('modules.calendar.index')->with('success', 'Schedule created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $schedule = Schedule::query()->findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'date' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
        $schedule->update($validated);
        return redirect()->route('modules.calendar.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(string $id)
    {
        Schedule::query()->findOrFail($id)->delete();
        return redirect()->route('modules.calendar.index')->with('success', 'Schedule deleted successfully.');
    }

    public function taskStore(Request $request)
    {
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:180'],
            'frequency' => ['required', 'in:daily,weekly,monthly'],
            'meta' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        $validated['meta'] = ['payload' => $validated['meta'] ?? null];
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        RecurringTask::query()->create($validated);
        return redirect()->route('modules.calendar.index')->with('success', 'Recurring task created successfully.');
    }

    public function taskUpdate(Request $request, string $id)
    {
        $task = RecurringTask::query()->findOrFail($id);
        $validated = $request->validate([
            'task_name' => ['required', 'string', 'max:180'],
            'frequency' => ['required', 'in:daily,weekly,monthly'],
            'meta' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $validated['meta'] = ['payload' => $validated['meta'] ?? null];
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $task->update($validated);
        return redirect()->route('modules.calendar.index')->with('success', 'Recurring task updated successfully.');
    }

    public function taskDestroy(string $id)
    {
        RecurringTask::query()->findOrFail($id)->delete();
        return redirect()->route('modules.calendar.index')->with('success', 'Recurring task deleted successfully.');
    }
}
