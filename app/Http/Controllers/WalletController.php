<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Show wallet dashboard
    public function index()
    {
        // ...logic stub
        return view('wallets.index');
    }
}
