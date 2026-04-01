@extends('modules.layout', ['title' => 'Document Vault'])

@section('content')
@include('modules.shared.list', [
    'heading' => 'Documents',
    'subheading' => 'Aadhaar, PAN and marksheet vault',
    'createRoute' => route('modules.documents.create'),
    'columns' => ['User ID', 'Type', 'File Path'],
    'rows' => $documents,
    'rowRenderer' => function($row) { return [$row->user_id, $row->type, $row->file_path]; },
    'routeBase' => 'modules.documents',
])
@endsection
