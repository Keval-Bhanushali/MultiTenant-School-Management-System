@extends('resources.layout', ['title' => 'Edit Notice'])

@section('content')
<form method="POST" action="{{ route('resources.notices.update', $notice->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6">
    @csrf
    @method('PUT')
    <input name="title" value="{{ $notice->title }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="message" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">{{ $notice->message }}</textarea>
    <input name="target_role" value="{{ $notice->target_role }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="scope" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="school" @selected($notice->scope === 'school')>School</option>
        <option value="all" @selected($notice->scope === 'all')>All Schools</option>
    </select>
    <button class="rounded-xl bg-indigo-600 px-4 py-2">Update Notice</button>
</form>
@endsection
