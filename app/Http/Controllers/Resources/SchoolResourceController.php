<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolResourceController extends Controller
{
    public function index()
    {
        $schools = School::query()->latest()->paginate(12);
        return view('resources.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('resources.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:40'],
            'owner_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['nullable', 'string', 'max:40'],
        ]);

        School::query()->create($validated);

        return redirect()->route('resources.schools.index')->with('success', 'School created successfully.');
    }

    public function show(string $id)
    {
        $school = School::query()->findOrFail($id);
        return view('resources.schools.show', compact('school'));
    }

    public function edit(string $id)
    {
        $school = School::query()->findOrFail($id);
        return view('resources.schools.edit', compact('school'));
    }

    public function update(Request $request, string $id)
    {
        $school = School::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:40'],
            'owner_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['nullable', 'string', 'max:40'],
        ]);

        $school->update($validated);

        return redirect()->route('resources.schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy(string $id)
    {
        $school = School::query()->findOrFail($id);
        $school->delete();

        return redirect()->route('resources.schools.index')->with('success', 'School deleted successfully.');
    }
}
