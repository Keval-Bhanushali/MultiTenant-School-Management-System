@extends('resources.layout', ['title' => 'Edit Attendance'])

@section('content')
<form method="POST" action="{{ route('resources.attendance.update', $attendance->_id) }}" class="grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <input type="date" name="date" value="{{ \Illuminate\Support\Str::of($attendance->date)->substr(0, 10) }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="status" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="present" @selected($attendance->status === 'present')>Present</option>
        <option value="absent" @selected($attendance->status === 'absent')>Absent</option>
        <option value="leave" @selected($attendance->status === 'leave')>Leave</option>
    </select>
    <input name="remark" value="{{ $attendance->remark }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-indigo-600 px-4 py-2">Update Attendance</button>
</form>
@endsection
