@extends('layouts.MainLayout')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="rounded-3xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl p-8 mb-8 flex flex-col items-center">
        <x-heroicon-o-camera class="w-10 h-10 text-cyan-400 drop-shadow mb-2" />
        <h2 class="text-3xl font-bold text-white mb-2">AI Attendance</h2>
        <p class="text-white/70 mb-6">Trigger camera for face detection or use Bluetooth for proximity check-in.</p>
        <div class="flex gap-4 mb-6">
            <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-lg shadow-indigo-500/30 hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <x-heroicon-o-camera class="w-5 h-5" /> Start Camera
            </button>
            <button class="px-6 py-3 rounded-xl bg-white/10 border border-white/20 text-white font-semibold shadow-lg hover:bg-white/20 transition-all duration-300">
                <x-heroicon-o-device-mobile class="w-5 h-5" /> Bluetooth Check-In
            </button>
        </div>
        <div class="w-full h-64 bg-black/30 rounded-xl flex items-center justify-center text-white/60">
            <!-- Camera feed or Bluetooth status will appear here -->
            <span>Camera/Bluetooth status...</span>
        </div>
    </div>
</div>
@endsection
