@extends('resources.layout', ['title' => 'Schools Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Schools',
    'createRoute' => route('resources.schools.create'),
    'columns' => ['Name', 'Code', 'Email'],
    'rows' => $schools,
    'rowRenderer' => function($row) { return [$row->name, $row->code, $row->email]; },
    'routeBase' => 'resources.schools',
])
@endsection
