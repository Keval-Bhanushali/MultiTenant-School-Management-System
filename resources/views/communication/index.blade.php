@extends('layouts.MainLayout')

@section('title', 'Communication Hub & Multilingual Auto-Translation')

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
            <svg class="w-8 h-8 text-indigo-400 drop-shadow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Communication Hub & Multilingual Auto-Translation
        </h2>
        <!-- Notice Composer -->
        <form class="flex flex-col gap-4">
            <label class="block text-white/80 font-semibold">Compose Notice</label>
            <textarea rows="3" placeholder="Type your notice here..." class="bg-transparent border border-white/20 rounded-xl shadow-inner px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-300"></textarea>
            <label class="block text-white/80 font-semibold">Target Audience</label>
            <select class="bg-transparent border border-white/20 rounded-xl shadow-inner px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-300">
                <option value="all">All Schools</option>
                <option value="school">Specific School</option>
                <option value="role">By Role</option>
            </select>
            <button type="submit" class="mt-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-500/40">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 9l5-5 5 5M12 4v12"/></svg>
                    Send Notice
                </span>
            </button>
        </form>
        <!-- AI Translation Results Placeholder -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold text-white/90 mb-2">AI Translated Notices</h3>
            <div class="rounded-xl bg-white/10 border border-white/20 p-4 text-white/80 shadow-inner min-h-[80px]">
                <em>Translated notices will appear here...</em>
            </div>
        </div>
        <!-- WhatsApp/Email Integration Stubs -->
        <div class="mt-8 flex gap-4">
            <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-400 to-lime-600 text-white font-bold shadow-lg shadow-green-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-lime-500/40">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Send via WhatsApp
                </span>
            </button>
            <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-400 to-cyan-600 text-white font-bold shadow-lg shadow-blue-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-cyan-500/40">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Send via Email
                </span>
            </button>
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
<script>
// Placeholder for gradient mesh, tsparticles, and loader logic
</script>
@endpush
