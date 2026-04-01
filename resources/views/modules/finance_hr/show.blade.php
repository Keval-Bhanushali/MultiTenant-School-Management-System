@extends('modules.layout', ['title' => 'Payroll Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">{{ $payroll->staff_member_name }}</h2>
    <p class="mt-2">Month: {{ $payroll->month }}</p>
    <p>Gross Salary: {{ $payroll->gross_salary }}</p>
    <p>Deductions: {{ $payroll->deductions }}</p>
    <p>Net Salary: {{ $payroll->net_salary }}</p>
    <p>Status: {{ $payroll->status ?? 'pending' }}</p>
</div>
@endsection
