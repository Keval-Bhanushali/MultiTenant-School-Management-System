@extends('layouts.MainLayout')

@section('title', 'Gamification - House Points Leaderboard')

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
            <svg class="w-8 h-8 text-yellow-400 drop-shadow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            House Points Leaderboard
        </h2>
        <!-- Leaderboard Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-white/90 rounded-xl overflow-hidden">
                <thead>
                    <tr class="bg-white/10">
                        <th class="px-4 py-2 text-left">Rank</th>
                        <th class="px-4 py-2 text-left">House</th>
                        <th class="px-4 py-2 text-left">Points</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example rows -->
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-2 font-bold">1</td>
                        <td class="px-4 py-2 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span> Phoenix</td>
                        <td class="px-4 py-2">1,250</td>
                    </tr>
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-2 font-bold">2</td>
                        <td class="px-4 py-2 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-400 animate-pulse"></span> Griffin</td>
                        <td class="px-4 py-2">1,120</td>
                    </tr>
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-2 font-bold">3</td>
                        <td class="px-4 py-2 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span> Hydra</td>
                        <td class="px-4 py-2">1,050</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">4</td>
                        <td class="px-4 py-2 flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-400 animate-pulse"></span> Dragon</td>
                        <td class="px-4 py-2">980</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- 4D Animated Progress Bar -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-white/90 mb-2">Current House Progress</h3>
            <div class="w-full bg-white/10 border border-white/20 rounded-xl h-8 shadow-inner overflow-hidden relative">
                <div class="absolute inset-0 flex items-center justify-between px-4 text-xs text-white/60">
                    <span>Phoenix</span>
                    <span>Griffin</span>
                    <span>Hydra</span>
                    <span>Dragon</span>
                </div>
                <div class="h-8 bg-gradient-to-r from-yellow-400 via-blue-400 to-green-400 rounded-xl shadow-lg shadow-indigo-500/30 animate-progress-bar" style="width: 65%"></div>
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
<script>
// Placeholder for gradient mesh, tsparticles, and loader logic
</script>
@endpush
