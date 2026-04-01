<?php

namespace App\Http\Controllers\Modules\FinanceHr;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\PayrollRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceHrController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $payrollRecords = PayrollRecord::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(10, ['*'], 'payroll');
        $feeInvoices = FeeInvoice::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(10, ['*'], 'fees');
        return view('modules.finance_hr.index', compact('payrollRecords', 'feeInvoices'));
    }

    public function create()
    {
        return view('modules.finance_hr.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_member_name' => ['required', 'string', 'max:180'],
            'month' => ['required', 'string', 'max:40'],
            'gross_salary' => ['required', 'numeric', 'min:0'],
            'deductions' => ['required', 'numeric', 'min:0'],
            'net_salary' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        PayrollRecord::query()->create($validated);
        return redirect()->route('modules.finance_hr.index')->with('success', 'Payroll record created successfully.');
    }

    public function show(string $id)
    {
        $payroll = PayrollRecord::query()->findOrFail($id);
        return view('modules.finance_hr.show', compact('payroll'));
    }

    public function edit(string $id)
    {
        $payroll = PayrollRecord::query()->findOrFail($id);
        return view('modules.finance_hr.edit', compact('payroll'));
    }

    public function update(Request $request, string $id)
    {
        $payroll = PayrollRecord::query()->findOrFail($id);
        $validated = $request->validate([
            'staff_member_name' => ['required', 'string', 'max:180'],
            'month' => ['required', 'string', 'max:40'],
            'gross_salary' => ['required', 'numeric', 'min:0'],
            'deductions' => ['required', 'numeric', 'min:0'],
            'net_salary' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);
        $payroll->update($validated);
        return redirect()->route('modules.finance_hr.index')->with('success', 'Payroll record updated successfully.');
    }

    public function destroy(string $id)
    {
        PayrollRecord::query()->findOrFail($id)->delete();
        return redirect()->route('modules.finance_hr.index')->with('success', 'Payroll record deleted successfully.');
    }
}
