@extends('resources.layout', ['title' => 'Attendance Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Attendance',
    'createRoute' => route('resources.attendance.create'),
    'columns' => ['Entity', 'Date', 'Status'],
    'rows' => $attendances,
    'rowRenderer' => function($row) { return [$row->entity_type . ' / ' . $row->entity_id, $row->date, $row->status]; },
    'routeBase' => 'resources.attendance',
])
@endsection
