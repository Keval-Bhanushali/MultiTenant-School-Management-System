@extends('resources.layout', ['title' => 'Teacher Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $teacher->name }}</h2>
    <p class="mt-2">Email: {{ $teacher->email }}</p>
    <p>Phone: {{ $teacher->phone }}</p>
    <p>Specialization: {{ $teacher->subject_specialization }}</p>
</div>
@endsection
