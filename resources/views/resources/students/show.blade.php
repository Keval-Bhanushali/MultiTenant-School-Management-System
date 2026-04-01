@extends('resources.layout', ['title' => 'Student Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $student->name }}</h2>
    <p class="mt-2">Email: {{ $student->email }}</p>
    <p>Roll Number: {{ $student->roll_number }}</p>
    <p>Class ID: {{ $student->class_id }}</p>
    <p>Guardian: {{ $student->guardian_name }}</p>
</div>
@endsection
