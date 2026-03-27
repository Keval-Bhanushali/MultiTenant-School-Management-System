@extends('layouts.MainLayout')

@section('title', 'Dynamic Finance & HR')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-cyan-900 relative overflow-hidden">
    <!-- Animated Gradient Mesh & Particle Layer (background) -->
    <div class="absolute inset-0 -z-10">
        <div id="gradient-mesh" class="w-full h-full"></div>
        <canvas id="tsparticles" class="absolute inset-0 w-full h-full"></canvas>
        <!-- Floating 4D Elements -->
        <div class="absolute top-10 left-10 w-40 h-40 bg-purple-400/30 rounded-full blur-3xl animate-spin-slow"></div>
        <div class="absolute bottom-20 right-20 w-56 h-56 bg-cyan-400/20 rounded-3xl blur-2xl animate-float"></div>
        <div class="absolute top-1/2 left-1/3 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl animate-float-reverse"></div>
        <!-- New 4D Elements -->
        <div class="absolute top-1/4 right-1/4 w-28 h-28 bg-pink-400/20 rounded-full blur-2xl animate-float"></div>
        <div class="absolute bottom-10 left-1/2 w-36 h-20 bg-gradient-to-r from-cyan-400/30 to-purple-400/30 rounded-3xl blur-2xl animate-float-reverse"></div>
        <div class="absolute top-2/3 right-1/5 w-24 h-24 bg-yellow-300/20 rounded-full blur-2xl animate-spin-slow"></div>
    </div>
    <!-- Glassmorphic Card -->
    <div class="w-full max-w-2xl p-8 rounded-3xl backdrop-blur-2xl bg-white/10 border border-white/20 shadow-2xl flex flex-col gap-8">
        <h2 class="text-3xl font-bold text-white flex items-center gap-2">
            <svg class="w-8 h-8 text-green-400 drop-shadow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/></svg>
            Dynamic Finance & HR
        </h2>
        <!-- Payroll Generator -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-white/90 mb-2">Automated Payroll Generator</h3>
            <form class="flex flex-col gap-4">
                <label class="block text-white/80 font-semibold">Select Month</label>
                <input type="month" class="bg-transparent border border-white/20 rounded-xl shadow-inner px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-300" />
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-500/40">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M12 4v16m8-8H4"/></svg>
                        Generate Payroll
                    </span>
                </button>
            </form>
            <div class="rounded-xl bg-white/10 border border-white/20 p-4 text-white/80 shadow-inner min-h-[80px] mt-4">
                <em>Payroll summary will appear here...</em>
            </div>
        </div>
        <!-- Fee Payment Gateway -->
        <div>
            <h3 class="text-xl font-semibold text-white/90 mb-2">Fee Payment Gateway</h3>
            <form id="razorpay-form" class="flex flex-col gap-4">
                <label class="block text-white/80 font-semibold">Amount</label>
                <input id="razorpay-amount" name="amount" type="number" min="1" placeholder="Enter amount" class="bg-transparent border border-white/20 rounded-xl shadow-inner px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-300" required />
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-400 to-cyan-600 text-white font-bold shadow-lg shadow-green-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-cyan-500/40">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 9l5-5 5 5M12 4v12"/></svg>
                        Pay with Razorpay
                    </span>
                </button>
            </form>
            <div id="razorpay-status" class="rounded-xl bg-white/10 border border-white/20 p-4 text-white/80 shadow-inner min-h-[80px] mt-4">
                <em>Payment status will appear here...</em>
            </div>
        </div>
    </div>
    <!-- Loader Overlay (hidden by default) -->
    <div id="global-loader" class="fixed inset-0 z-50 hidden items-center justify-center bg-white/20 backdrop-blur-2xl">
        <!-- 4D Morphing Blob Loader -->
        <svg class="w-32 h-32 animate-pulse" viewBox="0 0 100 100">
            <defs>
                <radialGradient id="blobGradient" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#a5b4fc"/>
                    <stop offset="100%" stop-color="#818cf8"/>
                </radialGradient>
            </defs>
            <path fill="url(#blobGradient)">
                <animate attributeName="d" dur="2.5s" repeatCount="indefinite"
                    values="M40,60 Q50,90 60,60 Q90,50 60,40 Q50,10 40,40 Q10,50 40,60Z;
                            M45,65 Q50,90 65,65 Q90,50 65,35 Q50,10 35,35 Q10,50 45,65Z;
                            M40,60 Q50,90 60,60 Q90,50 60,40 Q50,10 40,40 Q10,50 40,60Z"/>
            </path>
        </svg>
        <span class="sr-only">Loading...</span>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
// Razorpay Payment Integration
document.getElementById('razorpay-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const amount = document.getElementById('razorpay-amount').value;
    const statusDiv = document.getElementById('razorpay-status');
    statusDiv.innerHTML = '<span class="text-blue-400">Processing payment...</span>';
    try {
        const res = await fetch("{{ route('finance.pay.razorpay') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ amount })
        });
        const data = await res.json();
        if (!data.order_id) throw new Error('Order creation failed');
        const options = {
            key: data.key,
            amount: data.amount,
            currency: data.currency,
            name: '[NEW_NAME] Fee Payment',
            description: 'School Fee Payment',
            order_id: data.order_id,
            handler: function (response) {
                statusDiv.innerHTML = '<span class="text-green-400">Payment successful! Razorpay Payment ID: ' + response.razorpay_payment_id + '</span>';
            },
            prefill: {
                email: '{{ auth()->user()->email ?? '' }}',
            },
            theme: {
                color: '#06b6d4'
            }
        };
        const rzp = new Razorpay(options);
        rzp.open();
    } catch (err) {
        statusDiv.innerHTML = '<span class="text-red-400">Payment failed: ' + err.message + '</span>';
    }
});
// Placeholder for gradient mesh, tsparticles, and loader logic
</script>
@endpush
