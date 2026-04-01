@extends('modules.layout', ['title' => 'Alumni Network'])

@section('content')
@include('modules.shared.list', [
    'heading' => 'Alumni Profiles',
    'subheading' => 'Graduate networking and placement records',
    'createRoute' => route('modules.alumni.create'),
    'columns' => ['User ID', 'Company', 'Designation'],
    'rows' => $alumni,
    'rowRenderer' => function($row) { return [$row->user_id, $row->company_name, $row->designation]; },
    'routeBase' => 'modules.alumni',
])
@endsection
