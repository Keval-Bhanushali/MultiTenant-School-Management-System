@extends('modules.layout', ['title' => 'Edit Schedule'])

@section('content')
<form method="POST" action="{{ route('modules.calendar.update', $schedule->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $schedule->name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="date" name="date" value="{{ \Illuminate\Support\Str::of($schedule->date)->substr(0, 10) }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" value="{{ $schedule->status ?? 'active' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="notes" value="{{ $schedule->notes ?? '' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Schedule</button>
</form>
@endsection
