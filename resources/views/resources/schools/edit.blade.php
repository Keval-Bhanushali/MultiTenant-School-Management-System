@extends('resources.layout', ['title' => 'Edit School'])

@section('content')
<form method="POST" action="{{ route('resources.schools.update', $school->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $school->name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="code" value="{{ $school->code }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="owner_name" value="{{ $school->owner_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" value="{{ $school->email }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="phone" value="{{ $school->phone }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" value="{{ $school->status }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Update School</button>
</form>
@endsection
