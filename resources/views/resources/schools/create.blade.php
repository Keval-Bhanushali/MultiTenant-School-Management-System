@extends('resources.layout', ['title' => 'Create School'])

@section('content')
<form method="POST" action="{{ route('resources.schools.store') }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    <input name="name" placeholder="School Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="code" placeholder="School Code" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="owner_name" placeholder="Owner Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" placeholder="Email" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="phone" placeholder="Phone" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" placeholder="Status" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Save School</button>
</form>
@endsection
