<?php

namespace App\Http\Controllers\Modules\Realtime;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtimeController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $sessions = LiveSession::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        return view('modules.realtime.index', compact('sessions'));
    }

    public function create()
    {
        return view('modules.realtime.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'teacher_name' => ['required', 'string', 'max:180'],
            'meeting_link' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        LiveSession::query()->create($validated);
        return redirect()->route('modules.realtime.index')->with('success', 'Live session created successfully.');
    }

    public function show(string $id)
    {
        $session = LiveSession::query()->findOrFail($id);
        return view('modules.realtime.show', compact('session'));
    }

    public function edit(string $id)
    {
        $session = LiveSession::query()->findOrFail($id);
        return view('modules.realtime.edit', compact('session'));
    }

    public function update(Request $request, string $id)
    {
        $session = LiveSession::query()->findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'teacher_name' => ['required', 'string', 'max:180'],
            'meeting_link' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);
        $session->update($validated);
        return redirect()->route('modules.realtime.index')->with('success', 'Live session updated successfully.');
    }

    public function destroy(string $id)
    {
        LiveSession::query()->findOrFail($id)->delete();
        return redirect()->route('modules.realtime.index')->with('success', 'Live session deleted successfully.');
    }
}
