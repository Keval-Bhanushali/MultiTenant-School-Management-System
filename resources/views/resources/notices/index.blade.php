@extends('resources.layout', ['title' => 'Notices Resource'])

@section('content')
@include('resources.shared.list', [
    'heading' => 'Notices',
    'createRoute' => route('resources.notices.create'),
    'columns' => ['Title', 'Target Role', 'Scope'],
    'rows' => $notices,
    'rowRenderer' => function($row) { return [$row->title, $row->target_role, $row->scope]; },
    'routeBase' => 'resources.notices',
])
@endsection
