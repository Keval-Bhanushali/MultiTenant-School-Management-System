@extends('resources.layout', ['title' => 'Create Attendance'])

@section('content')
<form method="POST" action="{{ route('resources.attendance.store') }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    <select name="entity_type" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
        <option value="staff">Staff</option>
    </select>
    <input name="entity_id" placeholder="Entity ID" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="date" name="date" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="status" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="present">Present</option>
        <option value="absent">Absent</option>
        <option value="leave">Leave</option>
    </select>
    <input name="remark" placeholder="Remark" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Save Attendance</button>
</form>
@endsection
