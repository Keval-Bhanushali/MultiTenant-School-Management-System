@extends('resources.layout', ['title' => 'Create Notice'])

@section('content')
<form method="POST" action="{{ route('resources.notices.store') }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6">
    @csrf
    <input name="title" placeholder="Notice Title" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="message" placeholder="Notice Message" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2"></textarea>
    <input name="target_role" placeholder="Target Role" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="scope" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="school">School</option>
        <option value="all">All Schools</option>
    </select>
    <button class="rounded-xl bg-indigo-600 px-4 py-2">Save Notice</button>
</form>
@endsection
