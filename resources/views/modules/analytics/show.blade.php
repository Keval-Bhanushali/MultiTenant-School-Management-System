@extends('modules.layout', ['title' => 'Insight Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">{{ $insight->student_name }}</h2>
    <p class="mt-2">Risk Level: {{ $insight->risk_level }}</p>
    <p>Attendance: {{ $insight->attendance_rate }}%</p>
    <p>Score: {{ $insight->test_score }}%</p>
    <p class="mt-4">{{ $insight->recommendation ?? '-' }}</p>
</div>
@endsection
