@extends('modules.layout', ['title' => 'Edit Wallet'])

@section('content')
<form method="POST" action="{{ route('modules.wallet.update', $wallet->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="user_id" value="{{ $wallet->user_id }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="balance" type="number" step="0.01" value="{{ $wallet->balance }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" value="{{ $wallet->status ?? 'active' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Wallet</button>
</form>
@endsection
