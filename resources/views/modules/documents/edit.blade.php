@extends('modules.layout', ['title' => 'Edit Document'])

@section('content')
<form method="POST" action="{{ route('modules.documents.update', $document->_id) }}" class="grid gap-3 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-2xl md:grid-cols-2">
    @csrf
    @method('PUT')
    <input name="user_id" value="{{ $document->user_id }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <select name="type" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
        <option value="aadhaar_card" @selected($document->type==='aadhaar_card')>Aadhaar Card</option>
        <option value="pan_card" @selected($document->type==='pan_card')>PAN Card</option>
        <option value="marksheet" @selected($document->type==='marksheet')>Marksheet</option>
    </select>
    <input name="file_path" value="{{ $document->file_path }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <input name="status" value="{{ $document->status ?? 'active' }}" class="rounded-xl border border-white/20 bg-black/10 px-3 py-2">
    <button class="md:col-span-2 rounded-xl bg-gradient-to-r from-indigo-500 to-cyan-500 px-4 py-2">Update Document</button>
</form>
@endsection
