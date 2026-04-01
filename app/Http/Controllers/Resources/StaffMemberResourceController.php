<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMemberResourceController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $staffMembers = StaffMember::query()
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->latest()
            ->paginate(12);

        return view('resources.staff_members.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('resources.staff_members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:120'],
            'designation' => ['required', 'string', 'max:120'],
            'user_role' => ['required', 'string', 'max:40'],
        ]);

        $validated['school_id'] = $this->schoolScope() ?? (string) ($request->input('school_id') ?? '');
        StaffMember::query()->create($validated);

        return redirect()->route('resources.staff-members.index')->with('success', 'Staff member created successfully.');
    }

    public function show(string $id)
    {
        $staffMember = StaffMember::query()->findOrFail($id);
        return view('resources.staff_members.show', compact('staffMember'));
    }

    public function edit(string $id)
    {
        $staffMember = StaffMember::query()->findOrFail($id);
        return view('resources.staff_members.edit', compact('staffMember'));
    }

    public function update(Request $request, string $id)
    {
        $staffMember = StaffMember::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:120'],
            'designation' => ['required', 'string', 'max:120'],
            'user_role' => ['required', 'string', 'max:40'],
        ]);

        $staffMember->update($validated);

        return redirect()->route('resources.staff-members.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(string $id)
    {
        $staffMember = StaffMember::query()->findOrFail($id);
        $staffMember->delete();

        return redirect()->route('resources.staff-members.index')->with('success', 'Staff member deleted successfully.');
    }
}
