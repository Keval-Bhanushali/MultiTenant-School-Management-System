@extends('modules.layout', ['title' => 'Realtime'])

@section('content')
@include('modules.shared.list', [
    'heading' => 'Live Sessions',
    'subheading' => 'Streaming classes and live events',
    'createRoute' => route('modules.realtime.create'),
    'columns' => ['Title', 'Teacher', 'Starts At', 'Status'],
    'rows' => $sessions,
    'rowRenderer' => function($row) { return [$row->title, $row->teacher_name, $row->starts_at, $row->status ?? 'scheduled']; },
    'routeBase' => 'modules.realtime',
])
@endsection
