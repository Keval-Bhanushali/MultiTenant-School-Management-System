<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $recentTenants = Tenant::query()->latest()->limit(8)->get();

        $monthlyRevenue = Transaction::query()
            ->whereIn('type', ['credit', 'topup', 'fee_payment'])
            ->where('status', 'success')
            ->get()
            ->groupBy(function ($transaction) {
                return optional($transaction->created_at)->format('M') ?? now()->format('M');
            })
            ->map(fn ($items) => round((float) $items->sum('amount'), 2));

        $activeTenantCounts = Tenant::query()
            ->get()
            ->groupBy(function ($tenant) {
                return optional($tenant->created_at)->format('M') ?? now()->format('M');
            })
            ->map(fn ($items) => $items->where('status', 'active')->count());

        $monthOrder = collect(range(0, 5))->map(fn ($offset) => now()->subMonths(5 - $offset)->format('M'));

        $revenueSeries = $monthOrder->map(fn ($month) => (float) ($monthlyRevenue[$month] ?? 0))->values();
        $tenantSeries = $monthOrder->map(fn ($month) => (int) ($activeTenantCounts[$month] ?? 0))->values();

        return view('superadmin.dashboard', [
            'summary' => [
                'tenants' => Tenant::query()->count(),
                'users' => User::query()->count(),
                'revenue' => round((float) Transaction::query()
                    ->whereIn('type', ['credit', 'topup', 'fee_payment'])
                    ->where('status', 'success')
                    ->sum('amount'), 2),
                'walletTransactions' => Transaction::query()->count(),
            ],
            'recentTenants' => $recentTenants,
            'chart' => [
                'labels' => $monthOrder->values(),
                'revenue' => $revenueSeries,
                'tenants' => $tenantSeries,
            ],
        ]);
    }
}
