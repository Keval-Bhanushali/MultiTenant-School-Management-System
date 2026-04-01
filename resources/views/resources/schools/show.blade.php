@extends('resources.layout', ['title' => 'School Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $school->name }}</h2>
    <p class="mt-2">Code: {{ $school->code }}</p>
    <p>Email: {{ $school->email }}</p>
    <p>Phone: {{ $school->phone }}</p>
    <p>Owner: {{ $school->owner_name }}</p>
    <p>Status: {{ $school->status }}</p>
</div>
@endsection
