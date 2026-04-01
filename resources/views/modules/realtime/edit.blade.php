@extends('modules.layout', ['title' => 'Edit Live Session'])

@section('content')
<form method="POST" action="{{ route('modules.realtime.update', $session->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="title" value="{{ $session->title }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="teacher_name" value="{{ $session->teacher_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="meeting_link" value="{{ $session->meeting_link }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="datetime-local" name="starts_at" value="{{ \Illuminate\Support\Carbon::parse($session->starts_at)->format('Y-m-d\TH:i') }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" value="{{ $session->status ?? 'scheduled' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Session</button>
</form>
@endsection
