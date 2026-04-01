<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentResourceController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $students = Student::query()
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->with('schoolClass')
            ->latest()
            ->paginate(12);

        return view('resources.students.index', compact('students'));
    }

    public function create()
    {
        $schoolId = $this->schoolScope();
        $classes = SchoolClass::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->get();
        return view('resources.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'roll_number' => ['required', 'string', 'max:40'],
            'class_id' => ['nullable', 'string'],
            'guardian_name' => ['nullable', 'string', 'max:120'],
        ]);

        $validated['school_id'] = $this->schoolScope() ?? (string) ($request->input('school_id') ?? '');
        Student::query()->create($validated);

        return redirect()->route('resources.students.index')->with('success', 'Student created successfully.');
    }

    public function show(string $id)
    {
        $student = Student::query()->with('schoolClass')->findOrFail($id);
        return view('resources.students.show', compact('student'));
    }

    public function edit(string $id)
    {
        $student = Student::query()->findOrFail($id);
        $schoolId = $this->schoolScope();
        $classes = SchoolClass::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->get();
        return view('resources.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, string $id)
    {
        $student = Student::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'roll_number' => ['required', 'string', 'max:40'],
            'class_id' => ['nullable', 'string'],
            'guardian_name' => ['nullable', 'string', 'max:120'],
        ]);

        $student->update($validated);

        return redirect()->route('resources.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(string $id)
    {
        $student = Student::query()->findOrFail($id);
        $student->delete();

        return redirect()->route('resources.students.index')->with('success', 'Student deleted successfully.');
    }
}
