@extends('resources.layout', ['title' => 'Edit Teacher'])

@section('content')
<form method="POST" action="{{ route('resources.teachers.update', $teacher->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $teacher->name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" value="{{ $teacher->email }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="phone" value="{{ $teacher->phone }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="subject_specialization" value="{{ $teacher->subject_specialization }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Update Teacher</button>
</form>
@endsection
