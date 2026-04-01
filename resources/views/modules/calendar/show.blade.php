@extends('modules.layout', ['title' => 'Schedule Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">{{ $schedule->name }}</h2>
    <p class="mt-2">Date: {{ $schedule->date }}</p>
    <p>Status: {{ $schedule->status ?? 'active' }}</p>
    <p>Notes: {{ $schedule->notes ?? '-' }}</p>
</div>
@endsection
