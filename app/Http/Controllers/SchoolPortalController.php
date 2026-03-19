<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolPortalController extends Controller
{
    public function index()
    {
        $teachers = Teacher::query()->latest()->get();
        $classes = SchoolClass::query()->with('teacher')->latest()->get();
        $students = Student::query()->with('schoolClass')->latest()->get();

        return view('portal', [
            'teachers' => $teachers,
            'classes' => $classes,
            'students' => $students,
            'stats' => [
                'teachers' => $teachers->count(),
                'classes' => $classes->count(),
                'students' => $students->count(),
            ],
        ]);
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject_specialization' => ['required', 'string', 'max:120'],
        ]);

        Teacher::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Teacher added successfully.');
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'section' => ['required', 'string', 'max:40'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'teacher_id' => ['nullable', 'string'],
            'room_number' => ['nullable', 'string', 'max:40'],
        ]);

        if (! empty($validated['teacher_id']) && ! Teacher::query()->where('_id', $validated['teacher_id'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['teacher_id' => 'Selected teacher does not exist.']);
        }

        SchoolClass::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Class added successfully.');
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'roll_number' => ['required', 'string', 'max:60'],
            'class_id' => ['required', 'string'],
            'guardian_name' => ['nullable', 'string', 'max:120'],
        ]);

        if (! SchoolClass::query()->where('_id', $validated['class_id'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['class_id' => 'Selected class does not exist.']);
        }

        Student::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Student added successfully.');
    }
}
