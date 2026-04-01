@extends('modules.layout', ['title' => 'Edit Insight'])

@section('content')
<form method="POST" action="{{ route('modules.analytics.update', $insight->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="student_name" value="{{ $insight->student_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="risk_level" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="low" @selected($insight->risk_level === 'low')>Low</option>
        <option value="medium" @selected($insight->risk_level === 'medium')>Medium</option>
        <option value="high" @selected($insight->risk_level === 'high')>High</option>
    </select>
    <input type="number" step="0.1" name="attendance_rate" value="{{ $insight->attendance_rate }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.1" name="test_score" value="{{ $insight->test_score }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="recommendation" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">{{ $insight->recommendation }}</textarea>
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Insight</button>
</form>
@endsection
