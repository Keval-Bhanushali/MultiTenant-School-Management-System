@extends('modules.layout', ['title' => 'Analytics'])

@section('content')
@include('modules.shared.list', [
    'heading' => 'At-Risk Insights',
    'subheading' => 'Monitor attendance, scores and intervention plans',
    'createRoute' => route('modules.analytics.create'),
    'columns' => ['Student', 'Risk', 'Attendance', 'Score'],
    'rows' => $insights,
    'rowRenderer' => function($row) { return [$row->student_name, $row->risk_level, $row->attendance_rate . '%', $row->test_score . '%']; },
    'routeBase' => 'modules.analytics',
])
@endsection
