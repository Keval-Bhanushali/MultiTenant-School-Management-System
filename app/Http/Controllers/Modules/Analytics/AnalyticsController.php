<?php

namespace App\Http\Controllers\Modules\Analytics;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $insights = AnalyticsInsight::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        return view('modules.analytics.index', compact('insights'));
    }

    public function create()
    {
        return view('modules.analytics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:180'],
            'risk_level' => ['required', 'in:low,medium,high'],
            'attendance_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'test_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'recommendation' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        AnalyticsInsight::query()->create($validated);
        return redirect()->route('modules.analytics.index')->with('success', 'Analytics insight created successfully.');
    }

    public function show(string $id)
    {
        $insight = AnalyticsInsight::query()->findOrFail($id);
        return view('modules.analytics.show', compact('insight'));
    }

    public function edit(string $id)
    {
        $insight = AnalyticsInsight::query()->findOrFail($id);
        return view('modules.analytics.edit', compact('insight'));
    }

    public function update(Request $request, string $id)
    {
        $insight = AnalyticsInsight::query()->findOrFail($id);
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:180'],
            'risk_level' => ['required', 'in:low,medium,high'],
            'attendance_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'test_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'recommendation' => ['nullable', 'string', 'max:1000'],
        ]);
        $insight->update($validated);
        return redirect()->route('modules.analytics.index')->with('success', 'Analytics insight updated successfully.');
    }

    public function destroy(string $id)
    {
        AnalyticsInsight::query()->findOrFail($id)->delete();
        return redirect()->route('modules.analytics.index')->with('success', 'Analytics insight deleted successfully.');
    }
}
