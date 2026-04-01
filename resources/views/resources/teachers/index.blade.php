@extends('resources.layout', ['title' => 'Teachers Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Teachers',
    'createRoute' => route('resources.teachers.create'),
    'columns' => ['Name', 'Email', 'Specialization'],
    'rows' => $teachers,
    'rowRenderer' => function($row) { return [$row->name, $row->email, $row->subject_specialization]; },
    'routeBase' => 'resources.teachers',
])
@endsection
