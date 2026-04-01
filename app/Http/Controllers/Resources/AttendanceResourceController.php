<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceResourceController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $attendances = Attendance::query()
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->latest()
            ->paginate(15);

        return view('resources.attendance.index', compact('attendances'));
    }

    public function create()
    {
        return view('resources.attendance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => ['required', 'in:student,teacher,staff'],
            'entity_id' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,leave'],
            'remark' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['school_id'] = $this->schoolScope() ?? (string) ($request->input('school_id') ?? '');
        Attendance::query()->create($validated);

        return redirect()->route('resources.attendance.index')->with('success', 'Attendance record created successfully.');
    }

    public function show(string $id)
    {
        $attendance = Attendance::query()->findOrFail($id);
        return view('resources.attendance.show', compact('attendance'));
    }

    public function edit(string $id)
    {
        $attendance = Attendance::query()->findOrFail($id);
        return view('resources.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, string $id)
    {
        $attendance = Attendance::query()->findOrFail($id);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,leave'],
            'remark' => ['nullable', 'string', 'max:500'],
        ]);

        $attendance->update($validated);

        return redirect()->route('resources.attendance.index')->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(string $id)
    {
        $attendance = Attendance::query()->findOrFail($id);
        $attendance->delete();

        return redirect()->route('resources.attendance.index')->with('success', 'Attendance record deleted successfully.');
    }
}
