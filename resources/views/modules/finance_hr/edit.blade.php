@extends('modules.layout', ['title' => 'Edit Payroll Record'])

@section('content')
<form method="POST" action="{{ route('modules.finance-hr.update', $payroll->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="staff_member_name" value="{{ $payroll->staff_member_name }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="month" value="{{ $payroll->month }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="gross_salary" value="{{ $payroll->gross_salary }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="deductions" value="{{ $payroll->deductions }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="net_salary" value="{{ $payroll->net_salary }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <input name="status" value="{{ $payroll->status ?? 'pending' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Payroll Record</button>
</form>
@endsection
