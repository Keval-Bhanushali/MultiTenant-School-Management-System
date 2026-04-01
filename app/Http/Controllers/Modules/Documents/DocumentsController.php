<?php

namespace App\Http\Controllers\Modules\Documents;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    private function schoolScope(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function index()
    {
        $schoolId = $this->schoolScope();
        $documents = Document::query()->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))->latest()->paginate(12);
        return view('modules.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('modules.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'type' => ['required', 'in:aadhaar_card,pan_card,marksheet'],
            'file_path' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['school_id'] = $this->schoolScope();
        Document::query()->create($validated);
        return redirect()->route('modules.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function show(string $id)
    {
        $document = Document::query()->findOrFail($id);
        return view('modules.documents.show', compact('document'));
    }

    public function edit(string $id)
    {
        $document = Document::query()->findOrFail($id);
        return view('modules.documents.edit', compact('document'));
    }

    public function update(Request $request, string $id)
    {
        $document = Document::query()->findOrFail($id);
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'type' => ['required', 'in:aadhaar_card,pan_card,marksheet'],
            'file_path' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);
        $document->update($validated);
        return redirect()->route('modules.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(string $id)
    {
        Document::query()->findOrFail($id)->delete();
        return redirect()->route('modules.documents.index')->with('success', 'Document deleted successfully.');
    }
}
