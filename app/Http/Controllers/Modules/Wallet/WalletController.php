<?php

namespace App\Http\Controllers\Modules\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $wallets = Wallet::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        $transactions = Transaction::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        return view('modules.wallet.index', compact('wallets', 'transactions'));
    }

    public function create()
    {
        return view('modules.wallet.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'balance' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        Wallet::query()->create($validated);

        return redirect()->route('modules.wallet.index')->with('success', 'Wallet created successfully.');
    }

    public function show(string $id)
    {
        $wallet = Wallet::query()->findOrFail($id);
        return view('modules.wallet.show', compact('wallet'));
    }

    public function edit(string $id)
    {
        $wallet = Wallet::query()->findOrFail($id);
        return view('modules.wallet.edit', compact('wallet'));
    }

    public function update(Request $request, string $id)
    {
        $wallet = Wallet::query()->findOrFail($id);
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'balance' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);
        $wallet->update($validated);
        return redirect()->route('modules.wallet.index')->with('success', 'Wallet updated successfully.');
    }

    public function destroy(string $id)
    {
        Wallet::query()->findOrFail($id)->delete();
        return redirect()->route('modules.wallet.index')->with('success', 'Wallet deleted successfully.');
    }
}
