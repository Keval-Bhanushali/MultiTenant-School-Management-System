@extends('layouts.MainLayout', ['title' => $title ?? 'AuraCampus Resources', 'pageTitle' => $title ?? 'AuraCampus Resources'])

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-300/30 bg-emerald-500/20 px-4 py-3">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-xl border border-red-300/30 bg-red-500/20 px-4 py-3">
            <ul class="list-disc pl-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
@endsection
