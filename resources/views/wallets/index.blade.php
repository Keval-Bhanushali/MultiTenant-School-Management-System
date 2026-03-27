@extends('layouts.MainLayout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="rounded-3xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl p-8 mb-8 flex flex-col items-center">
        <x-heroicon-o-currency-dollar class="w-10 h-10 text-indigo-400 drop-shadow mb-2" />
        <h2 class="text-3xl font-bold text-white mb-2">Cashless Campus Wallet</h2>
        <div class="text-4xl font-extrabold text-indigo-300 mb-4">${{ $wallet->balance ?? '0.00' }}</div>
        <div class="flex gap-4">
            <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-lg shadow-indigo-500/30 hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <x-heroicon-o-plus-circle class="w-5 h-5" /> Load Money (Stripe)
            </button>
            <button class="px-6 py-3 rounded-xl bg-white/10 border border-white/20 text-white font-semibold shadow-lg hover:bg-white/20 transition-all duration-300">
                <x-heroicon-o-qrcode class="w-5 h-5" /> Show QR for Payment
            </button>
        </div>
    </div>
    <div class="rounded-2xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-xl p-6">
        <h3 class="text-xl font-bold text-white mb-4">Recent Transactions</h3>
        <ul class="divide-y divide-white/10">
            @foreach($transactions as $txn)
            <li class="flex justify-between py-3 text-white/80">
                <span>{{ ucfirst($txn->type) }}</span>
                <span class="{{ $txn->type === 'credit' ? 'text-green-400' : 'text-red-400' }}">
                    {{ $txn->type === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                </span>
                <span class="text-xs">{{ $txn->created_at->diffForHumans() }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
