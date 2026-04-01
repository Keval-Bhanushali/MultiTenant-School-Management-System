@extends('resources.layout', ['title' => 'Create Staff Member'])

@section('content')
<form method="POST" action="{{ route('resources.staff-members.store') }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    <input name="name" placeholder="Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" placeholder="Email" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="phone" placeholder="Phone" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="department" placeholder="Department" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="designation" placeholder="Designation" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="user_role" placeholder="User Role" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Save Staff Member</button>
</form>
@endsection
