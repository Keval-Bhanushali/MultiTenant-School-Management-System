@extends('layouts.MainLayout', ['title' => 'AuraCampus Superadmin Dashboard', 'pageTitle' => 'Superadmin Dashboard'])

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="glass-card p-5">
        <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Total Tenants</p>
        <p class="mt-3 text-4xl font-semibold text-white">{{ $summary['tenants'] }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Platform Users</p>
        <p class="mt-3 text-4xl font-semibold text-white">{{ $summary['users'] }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Revenue</p>
        <p class="mt-3 text-4xl font-semibold text-white">${{ number_format($summary['revenue'], 2) }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs uppercase tracking-[0.18em] text-slate-300">Wallet TXNs</p>
        <p class="mt-3 text-4xl font-semibold text-white">{{ $summary['walletTransactions'] }}</p>
    </div>
</div>

<div class="mt-6 grid gap-4 lg:grid-cols-2">
    <div class="glass-card p-6">
        <p class="mb-4 text-sm uppercase tracking-[0.2em] text-cyan-200">Platform Revenue</p>
        <div class="h-64">
            <canvas
                class="h-full w-full"
                data-superadmin-chart="revenue"
                data-labels='@json($chart['labels'])'
                data-values='@json($chart['revenue'])'
            ></canvas>
        </div>
    </div>

    <div class="glass-card p-6">
        <p class="mb-4 text-sm uppercase tracking-[0.2em] text-fuchsia-200">Active Tenants</p>
        <div class="h-64">
            <canvas
                class="h-full w-full"
                data-superadmin-chart="tenants"
                data-labels='@json($chart['labels'])'
                data-values='@json($chart['tenants'])'
            ></canvas>
        </div>
    </div>
</div>

<div class="mt-6 grid gap-4 xl:grid-cols-3">
    <div class="glass-card p-6 xl:col-span-2">
        <p class="text-sm uppercase tracking-[0.2em] text-emerald-200">Enterprise Modules</p>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h3 class="text-lg font-semibold">Cashless Campus</h3>
                <p class="mt-2 text-sm text-slate-300">Stripe/Razorpay top-up, NFC and QR spend paths with guardian controls.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h3 class="text-lg font-semibold">AI Early Warning</h3>
                <p class="mt-2 text-sm text-slate-300">Detect at-risk students from attendance and assessment drift.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h3 class="text-lg font-semibold">Alumni & Placements</h3>
                <p class="mt-2 text-sm text-slate-300">Graduate network, donations, and university placement tracking.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h3 class="text-lg font-semibold">Realtime Campus</h3>
                <p class="mt-2 text-sm text-slate-300">GPS bus routes, WebRTC classes, and Bluetooth check-ins.</p>
            </div>
        </div>
    </div>

    <div class="glass-card p-6">
        <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Recent Tenants</p>
        <div class="mt-4 space-y-3">
            @forelse($recentTenants as $tenant)
                <div class="rounded-2xl border border-white/10 bg-white/5 px-3 py-2">
                    <p class="text-sm font-semibold text-white">{{ $tenant->name }}</p>
                    <p class="text-xs text-slate-300">{{ $tenant->domain }} • {{ $tenant->subscription_plan ?? 'starter' }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-300">No tenants onboarded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
