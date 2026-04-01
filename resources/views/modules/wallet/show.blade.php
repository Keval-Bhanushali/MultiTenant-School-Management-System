@extends('modules.layout', ['title' => 'Wallet Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">Wallet #{{ $wallet->_id }}</h2>
    <p class="mt-2">User ID: {{ $wallet->user_id }}</p>
    <p>Balance: {{ $wallet->balance }}</p>
    <p>Status: {{ $wallet->status ?? 'active' }}</p>
</div>
@endsection
