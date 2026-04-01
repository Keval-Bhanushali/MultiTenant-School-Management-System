@extends('modules.layout', ['title' => 'Cashless Campus'])

@section('content')
<div class="grid gap-6">
    @include('modules.shared.list', [
        'heading' => 'Wallets',
        'subheading' => 'Student balances and cashless campus wallets',
        'createRoute' => route('modules.wallet.create'),
        'columns' => ['User ID', 'Balance', 'Status'],
        'rows' => $wallets,
        'rowRenderer' => function($row) { return [$row->user_id, $row->balance, $row->status ?? 'active']; },
        'routeBase' => 'modules.wallet',
    ])

    @include('modules.shared.list', [
        'heading' => 'Transactions',
        'subheading' => 'NFC, QR, canteen and fee payment history',
        'createRoute' => route('modules.wallet.create'),
        'columns' => ['Wallet ID', 'Type', 'Amount'],
        'rows' => $transactions,
        'rowRenderer' => function($row) { return [$row->wallet_id, $row->type, $row->amount]; },
        'routeBase' => 'modules.wallet',
    ])
</div>
@endsection
