@extends('modules.layout', ['title' => 'Create Alumni Profile'])

@section('content')
<form method="POST" action="{{ route('modules.alumni.store') }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    <input name="user_id" placeholder="User ID" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="company_name" placeholder="Company Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="designation" placeholder="Designation" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="industry" placeholder="Industry" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <textarea name="bio" placeholder="Bio" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2"></textarea>
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Save Alumni Profile</button>
</form>
@endsection
