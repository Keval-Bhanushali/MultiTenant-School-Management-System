@extends('modules.layout', ['title' => 'Document Details'])

@section('content')
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl">
    <h2 class="text-xl font-semibold">Document #{{ $document->_id }}</h2>
    <p class="mt-2">User ID: {{ $document->user_id }}</p>
    <p>Type: {{ $document->type }}</p>
    <p>File Path: {{ $document->file_path }}</p>
    <p>Status: {{ $document->status ?? 'active' }}</p>
</div>
@endsection
