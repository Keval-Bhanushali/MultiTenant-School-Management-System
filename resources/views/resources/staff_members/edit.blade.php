@extends('resources.layout', ['title' => 'Edit Staff Member'])

@section('content')
<form method="POST" action="{{ route('resources.staff-members.update', $staffMember->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $staffMember->name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" value="{{ $staffMember->email }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="phone" value="{{ $staffMember->phone }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="department" value="{{ $staffMember->department }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="designation" value="{{ $staffMember->designation }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="user_role" value="{{ $staffMember->user_role }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Update Staff Member</button>
</form>
@endsection
