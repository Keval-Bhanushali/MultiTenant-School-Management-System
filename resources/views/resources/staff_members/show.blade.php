@extends('resources.layout', ['title' => 'Staff Member Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $staffMember->name }}</h2>
    <p class="mt-2">Email: {{ $staffMember->email }}</p>
    <p>Department: {{ $staffMember->department }}</p>
    <p>Designation: {{ $staffMember->designation }}</p>
    <p>User Role: {{ $staffMember->user_role }}</p>
</div>
@endsection
