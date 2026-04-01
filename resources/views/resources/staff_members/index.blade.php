@extends('resources.layout', ['title' => 'Staff Members Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Staff Members',
    'createRoute' => route('resources.staff-members.create'),
    'columns' => ['Name', 'Email', 'Department'],
    'rows' => $staffMembers,
    'rowRenderer' => function($row) { return [$row->name, $row->email, $row->department]; },
    'routeBase' => 'resources.staff-members',
])
@endsection
