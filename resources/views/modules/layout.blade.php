@extends('layouts.MainLayout', ['title' => $title ?? 'AuraCampus Module', 'pageTitle' => $title ?? 'AuraCampus Module'])

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-200/20 bg-emerald-500/15 px-4 py-3">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200/20 bg-red-500/15 px-4 py-3">
            <ul class="list-disc pl-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
@endsection
