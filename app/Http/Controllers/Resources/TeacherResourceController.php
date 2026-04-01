<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherResourceController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $teachers = Teacher::query()
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->latest()
            ->paginate(12);

        return view('resources.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('resources.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject_specialization' => ['required', 'string', 'max:120'],
        ]);

        $validated['school_id'] = $this->schoolScope() ?? (string) ($request->input('school_id') ?? '');
        Teacher::query()->create($validated);

        return redirect()->route('resources.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(string $id)
    {
        $teacher = Teacher::query()->findOrFail($id);
        return view('resources.teachers.show', compact('teacher'));
    }

    public function edit(string $id)
    {
        $teacher = Teacher::query()->findOrFail($id);
        return view('resources.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, string $id)
    {
        $teacher = Teacher::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject_specialization' => ['required', 'string', 'max:120'],
        ]);

        $teacher->update($validated);

        return redirect()->route('resources.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(string $id)
    {
        $teacher = Teacher::query()->findOrFail($id);
        $teacher->delete();

        return redirect()->route('resources.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
