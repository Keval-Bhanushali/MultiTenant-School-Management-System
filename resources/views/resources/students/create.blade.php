@extends('resources.layout', ['title' => 'Create Student'])

@section('content')
<form method="POST" action="{{ route('resources.students.store') }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    <input name="name" placeholder="Student Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" placeholder="Email" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="roll_number" placeholder="Roll Number" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="class_id" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="">Select Class</option>
        @foreach($classes as $class)
            <option value="{{ $class->_id }}">{{ $class->name }} - {{ $class->section }}</option>
        @endforeach
    </select>
    <input name="guardian_name" placeholder="Guardian Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Save Student</button>
</form>
@endsection
