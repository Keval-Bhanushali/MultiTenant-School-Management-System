<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeResourceController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $notices = Notice::query()
            ->when($schoolId, fn ($q) => $q->where(function ($inner) use ($schoolId) {
                $inner->where('scope', 'all')->orWhere('school_id', $schoolId);
            }))
            ->latest()
            ->paginate(12);

        return view('resources.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('resources.notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:3000'],
            'target_role' => ['required', 'string', 'max:40'],
            'scope' => ['required', 'in:school,all'],
        ]);

        $validated['school_id'] = $validated['scope'] === 'all' ? null : ($this->schoolScope() ?? (string) ($request->input('school_id') ?? ''));
        $validated['created_by'] = (string) Auth::id();
        $validated['publish_at'] = now();

        Notice::query()->create($validated);

        return redirect()->route('resources.notices.index')->with('success', 'Notice created successfully.');
    }

    public function show(string $id)
    {
        $notice = Notice::query()->findOrFail($id);
        return view('resources.notices.show', compact('notice'));
    }

    public function edit(string $id)
    {
        $notice = Notice::query()->findOrFail($id);
        return view('resources.notices.edit', compact('notice'));
    }

    public function update(Request $request, string $id)
    {
        $notice = Notice::query()->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:3000'],
            'target_role' => ['required', 'string', 'max:40'],
            'scope' => ['required', 'in:school,all'],
        ]);

        $validated['school_id'] = $validated['scope'] === 'all' ? null : ($this->schoolScope() ?? (string) ($request->input('school_id') ?? $notice->school_id));

        $notice->update($validated);

        return redirect()->route('resources.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(string $id)
    {
        $notice = Notice::query()->findOrFail($id);
        $notice->delete();

        return redirect()->route('resources.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
