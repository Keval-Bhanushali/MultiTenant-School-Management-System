@extends('resources.layout', ['title' => 'Attendance Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $attendance->entity_type }} / {{ $attendance->entity_id }}</h2>
    <p class="mt-2">Date: {{ $attendance->date }}</p>
    <p>Status: {{ $attendance->status }}</p>
    <p>Remark: {{ $attendance->remark }}</p>
</div>
@endsection
