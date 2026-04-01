@extends('modules.layout', ['title' => 'Alumni Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">{{ $alumnus->company_name }}</h2>
    <p class="mt-2">Designation: {{ $alumnus->designation }}</p>
    <p>Industry: {{ $alumnus->industry ?? '-' }}</p>
    <p>Status: {{ $alumnus->status ?? 'active' }}</p>
    <p class="mt-4">{{ $alumnus->bio ?? '-' }}</p>
</div>
@endsection
