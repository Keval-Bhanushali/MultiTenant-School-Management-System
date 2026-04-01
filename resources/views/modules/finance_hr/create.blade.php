@extends('modules.layout', ['title' => 'Create Payroll Record'])

@section('content')
<form method="POST" action="{{ route('modules.finance-hr.store') }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    <input name="staff_member_name" placeholder="Staff Member Name" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="month" placeholder="Month" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="gross_salary" placeholder="Gross Salary" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="deductions" placeholder="Deductions" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input type="number" step="0.01" name="net_salary" placeholder="Net Salary" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <input name="status" placeholder="Status" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2 md:col-span-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Save Payroll Record</button>
</form>
@endsection
