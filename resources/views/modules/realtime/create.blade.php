@extends('modules.layout', ['title' => 'Create Live Session'])

@section('content')
<form method="POST" action="{{ route('modules.realtime.store') }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    <input name="title" placeholder="Session Title" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="teacher_name" placeholder="Teacher Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="meeting_link" placeholder="Meeting Link" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="datetime-local" name="starts_at" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" placeholder="Status" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Save Session</button>
</form>
@endsection
