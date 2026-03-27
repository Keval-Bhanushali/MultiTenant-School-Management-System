<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceHrController extends Controller
{
    // Show finance & HR UI
    public function index()
    {
        return view('finance_hr.index');
    }

    // Handle Razorpay payment POST
    public function payWithRazorpay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $apiKey = config('services.razorpay.key');
        $apiSecret = config('services.razorpay.secret');

        // Use Razorpay PHP SDK (assumes composer require razorpay/razorpay)
        $api = new \Razorpay\Api\Api($apiKey, $apiSecret);
        $order = $api->order->create([
            'receipt' => uniqid('fee_'),
            'amount' => $request->amount * 100, // Amount in paise
            'currency' => 'INR',
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'key' => $apiKey,
        ]);
    }
}
