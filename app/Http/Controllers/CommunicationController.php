<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Announcement;
use App\Models\FileDocument;
use App\Services\Communication\NoticeTranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function __construct(private NoticeTranslationService $translationService)
    {
    }

    private function currentSchoolId(): ?string
    {
        $user = Auth::user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    // Messages
    public function getMessages(Request $request)
    {
        $user = Auth::user();
        $messages = Message::query()
            ->where(function ($query) use ($user) {
                $query->where('recipient_id', $user->_id)
                    ->orWhere('sender_id', $user->_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => ['required', 'string'],
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::query()->create([
            'school_id' => $this->currentSchoolId(),
            'sender_id' => (string) Auth::user()->_id,
            'recipient_id' => $validated['recipient_id'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $message,
        ]);
    }

    public function markMessageAsRead($id)
    {
        $message = Message::query()
            ->where('_id', $id)
            ->where('recipient_id', (string) Auth::user()->_id)
            ->firstOrFail();

        $message->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Marked as read.']);
    }

    public function deleteMessage($id)
    {
        Message::query()
            ->where('_id', $id)
            ->where(function ($query) {
                $userId = (string) Auth::user()->_id;
                $query->where('recipient_id', $userId)
                    ->orWhere('sender_id', $userId);
            })
            ->firstOrFail()
            ->delete();

        return response()->json(['success' => true, 'message' => 'Message deleted.']);
    }

    // Announcements
    public function getAnnouncements()
    {
        $user = Auth::user();
        $announcements = Announcement::query()
            ->where('school_id', $this->currentSchoolId())
            ->where(function ($query) use ($user) {
                $query->whereJsonContains('target_roles', $user->role)
                    ->orWhere('created_by', $user->_id);
            })
            ->where('published_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json($announcements);
    }

    public function createAnnouncement(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['superadmin', 'admin', 'staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'content' => ['required', 'string', 'max:3000'],
            'target_roles' => ['required', 'array'],
            'target_locales' => ['nullable', 'array'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $translatedMessages = collect($validated['target_locales'] ?? [])
            ->filter(fn ($locale) => is_string($locale) && $locale !== 'en')
            ->mapWithKeys(fn ($locale) => [
                $locale => $this->translationService->translateFromEnglish($validated['content'], $locale),
            ])
            ->toArray();

        $announcement = Announcement::query()->create([
            'school_id' => $this->currentSchoolId(),
            'created_by' => (string) $user->_id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'translated_messages' => $translatedMessages,
            'target_roles' => $validated['target_roles'],
            'priority' => $validated['priority'],
            'published_at' => now(),
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement published successfully.',
            'data' => $announcement,
        ]);
    }

    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail();

        if ((string) $announcement->created_by !== (string) Auth::user()->_id && Auth::user()->role !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $announcement->delete();

        return response()->json(['success' => true, 'message' => 'Announcement deleted.']);
    }

    // File Management
    public function uploadFile(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240'],
            'document_type' => ['required', 'in:assignment,exam,notice,syllabus,resource,other'],
            'description' => ['nullable', 'string', 'max:500'],
            'shared_with_roles' => ['nullable', 'array'],
        ]);

        if (!$request->file('file')) {
            return response()->json(['error' => 'No file provided'], 400);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $filePath = 'documents/' . $fileName;

        // Store file in storage/app/documents
        $file->storeAs('documents', $fileName, 'local');

        $fileDoc = FileDocument::query()->create([
            'school_id' => $this->currentSchoolId(),
            'uploader_id' => (string) Auth::user()->_id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'category' => $validated['document_type'],
            'document_type' => $validated['document_type'],
            'description' => $validated['description'] ?? null,
            'shared_with_roles' => $validated['shared_with_roles'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully.',
            'data' => $fileDoc,
        ]);
    }

    public function getFiles(Request $request)
    {
        $user = Auth::user();
        $files = FileDocument::query()
            ->where('school_id', $this->currentSchoolId())
            ->where(function ($query) use ($user) {
                $query->where('uploader_id', $user->_id)
                    ->orWhereJsonContains('shared_with_roles', $user->role);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($files);
    }

    public function downloadFile($id)
    {
        $user = Auth::user();
        $file = FileDocument::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail();

        $canAccess = (string) $file->uploader_id === (string) $user->_id
            || in_array($user->role, $file->shared_with_roles ?? [], true)
            || $user->role === 'admin';

        if (!$canAccess) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $absolutePath = storage_path('app/' . $file->file_path);
        if (!file_exists($absolutePath)) {
            return response()->json(['error' => 'File not found on disk'], 404);
        }

        return response()->download($absolutePath, $file->file_name);
    }

    public function deleteFile($id)
    {
        $file = FileDocument::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail();

        if ((string) $file->uploader_id !== (string) Auth::user()->_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete physical file
        if (file_exists(storage_path('app/' . $file->file_path))) {
            unlink(storage_path('app/' . $file->file_path));
        }

        $file->delete();

        return response()->json(['success' => true, 'message' => 'File deleted.']);
    }

    public function getStats()
    {
        $user = Auth::user();
        $schoolId = $this->currentSchoolId();

        return response()->json([
            'unread_messages' => Message::query()
                ->where('recipient_id', (string) $user->_id)
                ->where('is_read', false)
                ->count(),
            'total_announcements' => Announcement::query()
                ->where('school_id', $schoolId)
                ->where(function ($query) use ($user) {
                    $query->whereJsonContains('target_roles', $user->role);
                })
                ->count(),
            'total_files' => FileDocument::query()
                ->where('school_id', $schoolId)
                ->where(function ($query) use ($user) {
                    $query->where('uploader_id', $user->_id)
                        ->orWhereJsonContains('shared_with_roles', $user->role);
                })
                ->count(),
        ]);
    }
}
