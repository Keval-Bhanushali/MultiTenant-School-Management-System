@extends('modules.layout', ['title' => 'Session Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">{{ $session->title }}</h2>
    <p class="mt-2">Teacher: {{ $session->teacher_name }}</p>
    <p>Meeting Link: {{ $session->meeting_link }}</p>
    <p>Starts At: {{ $session->starts_at }}</p>
    <p>Status: {{ $session->status ?? 'scheduled' }}</p>
</div>
@endsection
