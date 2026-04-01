@extends('resources.layout', ['title' => 'Students Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Students',
    'createRoute' => route('resources.students.create'),
    'columns' => ['Name', 'Email', 'Roll Number'],
    'rows' => $students,
    'rowRenderer' => function($row) { return [$row->name, $row->email, $row->roll_number]; },
    'routeBase' => 'resources.students',
])
@endsection
