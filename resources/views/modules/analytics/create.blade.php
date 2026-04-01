@extends('modules.layout', ['title' => 'Create Insight'])

@section('content')
<form method="POST" action="{{ route('modules.analytics.store') }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    <input name="student_name" placeholder="Student Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="risk_level" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
    <input type="number" step="0.1" name="attendance_rate" placeholder="Attendance Rate" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.1" name="test_score" placeholder="Test Score" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="recommendation" placeholder="Recommendation" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2"></textarea>
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Save Insight</button>
</form>
@endsection
