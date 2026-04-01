@extends('modules.layout', ['title' => 'Finance & HR'])

@section('content')
<div class="grid gap-6">
    @include('modules.shared.list', [
        'heading' => 'Payroll Records',
        'subheading' => 'Salary processing and monthly payroll',
        'createRoute' => route('modules.finance-hr.create'),
        'columns' => ['Staff', 'Month', 'Gross', 'Net'],
        'rows' => $payrollRecords,
        'rowRenderer' => function($row) { return [$row->staff_member_name, $row->month, $row->gross_salary, $row->net_salary]; },
        'routeBase' => 'modules.finance-hr',
    ])

    @include('modules.shared.list', [
        'heading' => 'Fee Invoices',
        'subheading' => 'Tuition billing and receivables',
        'createRoute' => route('modules.finance-hr.create'),
        'columns' => ['Student', 'Invoice', 'Amount', 'Status'],
        'rows' => $feeInvoices,
        'rowRenderer' => function($row) { return [$row->student_name ?? '-', $row->invoice_number ?? '-', $row->amount ?? '-', $row->status ?? '-']; },
        'routeBase' => 'modules.finance-hr',
    ])
</div>
@endsection
