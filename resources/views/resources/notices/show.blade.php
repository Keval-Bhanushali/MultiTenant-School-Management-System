@extends('resources.layout', ['title' => 'Notice Details'])

@section('content')
<div class="rounded-2xl border border-white/20 bg-white/10 p-6">
    <h2 class="text-xl font-semibold">{{ $notice->title }}</h2>
    <p class="mt-2">Target Role: {{ $notice->target_role }}</p>
    <p>Scope: {{ $notice->scope }}</p>
    <p class="mt-4">{{ $notice->message }}</p>
</div>
@endsection
