@extends('layouts.MainLayout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="rounded-3xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl p-8 mb-8">
        <x-heroicon-o-users class="w-10 h-10 text-purple-400 drop-shadow mb-2" />
        <h2 class="text-3xl font-bold text-white mb-2">Alumni Network</h2>
        <p class="text-white/70 mb-6">Connect, donate, and track placements.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($alumni as $alum)
            <div class="rounded-xl bg-white/10 border border-white/20 p-6 flex flex-col items-center shadow-lg">
                <img src="{{ $alum->avatar }}" class="w-16 h-16 rounded-full mb-2 shadow" />
                <div class="font-bold text-white">{{ $alum->name }}</div>
                <div class="text-white/60 text-sm">{{ $alum->current_position }}</div>
                <a href="{{ $alum->profile_url }}" class="mt-2 text-indigo-400 underline">View Profile</a>
            </div>
            @endforeach
        </div>
        <div class="mt-8 flex gap-4">
            <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-lg shadow-indigo-500/30 hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                <x-heroicon-o-currency-dollar class="w-5 h-5" /> Donate
            </button>
            <button class="px-6 py-3 rounded-xl bg-white/10 border border-white/20 text-white font-semibold shadow-lg hover:bg-white/20 transition-all duration-300">
                <x-heroicon-o-academic-cap class="w-5 h-5" /> Placement Cell
            </button>
        </div>
    </div>
</div>
@endsection
