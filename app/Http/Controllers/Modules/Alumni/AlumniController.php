<?php

namespace App\Http\Controllers\Modules\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $alumni = AlumniProfile::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        return view('modules.alumni.index', compact('alumni'));
    }

    public function create()
    {
        return view('modules.alumni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'company_name' => ['required', 'string', 'max:180'],
            'designation' => ['required', 'string', 'max:180'],
            'industry' => ['nullable', 'string', 'max:180'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        AlumniProfile::query()->create($validated);
        return redirect()->route('modules.alumni.index')->with('success', 'Alumni profile created successfully.');
    }

    public function show(string $id)
    {
        $alumnus = AlumniProfile::query()->findOrFail($id);
        return view('modules.alumni.show', compact('alumnus'));
    }

    public function edit(string $id)
    {
        $alumnus = AlumniProfile::query()->findOrFail($id);
        return view('modules.alumni.edit', compact('alumnus'));
    }

    public function update(Request $request, string $id)
    {
        $alumnus = AlumniProfile::query()->findOrFail($id);
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'company_name' => ['required', 'string', 'max:180'],
            'designation' => ['required', 'string', 'max:180'],
            'industry' => ['nullable', 'string', 'max:180'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);
        $alumnus->update($validated);
        return redirect()->route('modules.alumni.index')->with('success', 'Alumni profile updated successfully.');
    }

    public function destroy(string $id)
    {
        AlumniProfile::query()->findOrFail($id)->delete();
        return redirect()->route('modules.alumni.index')->with('success', 'Alumni profile deleted successfully.');
    }
}
