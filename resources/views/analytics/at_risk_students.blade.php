@extends('layouts.MainLayout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="rounded-3xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl p-8 mb-8">
        <x-heroicon-o-exclamation class="w-10 h-10 text-red-400 drop-shadow mb-2" />
        <h2 class="text-3xl font-bold text-white mb-2">At-Risk Students</h2>
        <p class="text-white/70 mb-6">AI-powered early warning system. Students flagged based on attendance and test scores.</p>
        <table class="w-full text-white/90 rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-white/10">
                    <th class="p-3">Name</th>
                    <th class="p-3">Attendance</th>
                    <th class="p-3">Avg. Score</th>
                    <th class="p-3">Risk Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atRiskStudents as $student)
                <tr class="border-b border-white/10">
                    <td class="p-3">{{ $student->name }}</td>
                    <td class="p-3">{{ $student->attendance }}%</td>
                    <td class="p-3">{{ $student->average_score }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full bg-red-500/30 text-red-200">{{ $student->risk_level }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
