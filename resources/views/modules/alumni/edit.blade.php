@extends('modules.layout', ['title' => 'Edit Alumni Profile'])

@section('content')
<form method="POST" action="{{ route('modules.alumni.update', $alumnus->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="user_id" value="{{ $alumnus->user_id }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="company_name" value="{{ $alumnus->company_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="designation" value="{{ $alumnus->designation }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="industry" value="{{ $alumnus->industry }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="bio" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">{{ $alumnus->bio }}</textarea>
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Alumni Profile</button>
</form>
@endsection
