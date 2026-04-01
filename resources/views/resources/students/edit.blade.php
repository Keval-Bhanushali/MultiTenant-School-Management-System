@extends('resources.layout', ['title' => 'Edit Student'])

@section('content')
<form method="POST" action="{{ route('resources.students.update', $student->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="name" value="{{ $student->name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="email" value="{{ $student->email }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="roll_number" value="{{ $student->roll_number }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="class_id" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="">Select Class</option>
        @foreach($classes as $class)
            <option value="{{ $class->_id }}" @selected((string) $student->class_id === (string) $class->_id)>{{ $class->name }} - {{ $class->section }}</option>
        @endforeach
    </select>
    <input name="guardian_name" value="{{ $student->guardian_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Update Student</button>
</form>
@endsection
