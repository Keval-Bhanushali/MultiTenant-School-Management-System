<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Holiday;
use App\Models\Notice;
use App\Models\Result;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\StaffMember;
use App\Models\Standard;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolPortalController extends Controller
{
    public function index()
    {
        return view('portal', $this->portalData());
    }

    public function schoolPage()
    {
        return view('school.index', $this->portalData());
    }

    private function portalData(): array
    {
        $user = auth()->user();

        $teachersQuery = Teacher::query();
        $classesQuery = SchoolClass::query();
        $studentsQuery = Student::query();
        $standardsQuery = Standard::query();
        $subjectsQuery = Subject::query();
        $coursesQuery = Course::query();
        $staffQuery = StaffMember::query();
        $timetableQuery = TimetableEntry::query();
        $resultsQuery = Result::query();
        $noticesQuery = Notice::query();
        $holidaysQuery = Holiday::query();
        $attendanceQuery = Attendance::query();

        if ($user->role !== 'superadmin') {
            $schoolId = (string) $user->school_id;
            $teachersQuery->where('school_id', $schoolId);
            $classesQuery->where('school_id', $schoolId);
            $studentsQuery->where('school_id', $schoolId);
            $standardsQuery->where('school_id', $schoolId);
            $subjectsQuery->where('school_id', $schoolId);
            $coursesQuery->where('school_id', $schoolId);
            $staffQuery->where('school_id', $schoolId);
            $timetableQuery->where('school_id', $schoolId);
            $resultsQuery->where('school_id', $schoolId);
            $holidaysQuery->where('school_id', $schoolId);
            $attendanceQuery->where('school_id', $schoolId);
            $noticesQuery->where(function ($q) use ($schoolId) {
                $q->where('scope', 'all')->orWhere('school_id', $schoolId);
            });
        }

        $teachers = $teachersQuery->latest()->get();
        $classes = $classesQuery->with('teacher')->latest()->get();
        $students = $studentsQuery->with('schoolClass')->latest()->get();
        $standards = $standardsQuery->orderBy('order')->get();
        $subjects = $subjectsQuery->latest()->get();
        $courses = $coursesQuery->latest()->get();
        $staffMembers = $staffQuery->latest()->get();
        $timetableEntries = $timetableQuery->latest()->get();
        $results = $resultsQuery->latest()->get();
        $notices = $noticesQuery->latest()->get();
        $holidays = $holidaysQuery->latest()->get();
        $attendances = $attendanceQuery->latest()->get();
        $schools = School::query()->latest()->get();
        $schoolAdmins = User::query()->where('role', 'admin')->latest()->get();

        return [
            'currentUser' => $user,
            'teachers' => $teachers,
            'classes' => $classes,
            'students' => $students,
            'standards' => $standards,
            'subjects' => $subjects,
            'courses' => $courses,
            'staffMembers' => $staffMembers,
            'timetableEntries' => $timetableEntries,
            'results' => $results,
            'notices' => $notices,
            'holidays' => $holidays,
            'attendances' => $attendances,
            'schools' => $schools,
            'schoolAdmins' => $schoolAdmins,
            'stats' => [
                'teachers' => $teachers->count(),
                'classes' => $classes->count(),
                'students' => $students->count(),
            ],
        ];
    }

    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'code' => ['required', 'string', 'max:30'],
            'owner_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        School::query()->create($validated + ['status' => 'active']);

        return redirect()->route('portal.index')->with('success', 'School created successfully.');
    }

    public function storeSchoolAdmin(Request $request)
    {
        $validated = $request->validate([
            'school_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:180'],
            'password' => ['required', 'string', 'min:8', 'max:80'],
        ]);

        if (! School::query()->where('_id', $validated['school_id'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['school_id' => 'Selected school not found.']);
        }

        if (User::query()->where('username', $validated['username'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['username' => 'Username already exists.']);
        }

        User::query()->create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'admin',
            'school_id' => $validated['school_id'],
            'status' => 'active',
        ]);

        return redirect()->route('portal.index')->with('success', 'School admin created successfully.');
    }

    public function storeTeacher(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject_specialization' => ['required', 'string', 'max:120'],
        ]);

        if ($user->role === 'superadmin') {
            return redirect()->route('portal.index')->withErrors(['name' => 'Superadmin should create school admins, not school teachers directly.']);
        }

        $validated['school_id'] = (string) $user->school_id;

        Teacher::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Teacher added successfully.');
    }

    public function storeClass(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'section' => ['required', 'string', 'max:40'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'teacher_id' => ['nullable', 'string'],
            'room_number' => ['nullable', 'string', 'max:40'],
        ]);

        if ($user->role === 'superadmin') {
            return redirect()->route('portal.index')->withErrors(['name' => 'Superadmin should create school admins, not school classes directly.']);
        }

        $validated['school_id'] = (string) $user->school_id;

        if (! empty($validated['teacher_id']) && ! Teacher::query()->where('_id', $validated['teacher_id'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['teacher_id' => 'Selected teacher does not exist.']);
        }

        SchoolClass::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Class added successfully.');
    }

    public function storeStudent(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'roll_number' => ['required', 'string', 'max:60'],
            'class_id' => ['required', 'string'],
            'guardian_name' => ['nullable', 'string', 'max:120'],
        ]);

        if ($user->role === 'superadmin') {
            return redirect()->route('portal.index')->withErrors(['name' => 'Superadmin should create school admins, not school students directly.']);
        }

        $validated['school_id'] = (string) $user->school_id;

        if (! SchoolClass::query()->where('_id', $validated['class_id'])->exists()) {
            return redirect()->route('portal.index')->withErrors(['class_id' => 'Selected class does not exist.']);
        }

        Student::query()->create($validated);

        return redirect()->route('portal.index')->with('success', 'Student added successfully.');
    }

    public function storeStandard(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'order' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        Standard::query()->create([
            'school_id' => $this->currentSchoolId(),
            'name' => $validated['name'],
            'order' => $validated['order'],
            'status' => 'active',
        ]);

        return redirect()->route('portal.index')->with('success', 'Standard created successfully.');
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:30'],
        ]);

        Subject::query()->create([
            'school_id' => $this->currentSchoolId(),
            'standard_id' => $validated['standard_id'],
            'name' => $validated['name'],
            'code' => $validated['code'],
        ]);

        return redirect()->route('portal.index')->with('success', 'Subject created successfully.');
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:250'],
        ]);

        Course::query()->create([
            'school_id' => $this->currentSchoolId(),
            'standard_id' => $validated['standard_id'],
            'name' => $validated['name'],
            'subject_ids' => $request->input('subject_ids', []),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('portal.index')->with('success', 'Course created successfully.');
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:80'],
            'designation' => ['required', 'string', 'max:80'],
            'user_role' => ['required', 'string', 'max:50'],
        ]);

        StaffMember::query()->create([
            'school_id' => $this->currentSchoolId(),
            ...$validated,
        ]);

        return redirect()->route('portal.index')->with('success', 'Staff member created successfully.');
    }

    public function storeTimetable(Request $request)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'teacher_id' => ['nullable', 'string'],
            'day' => ['required', 'string', 'max:20'],
            'start_time' => ['required', 'string', 'max:10'],
            'end_time' => ['required', 'string', 'max:10'],
            'is_holiday' => ['nullable', 'boolean'],
            'holiday_type' => ['nullable', 'string', 'max:80'],
        ]);

        TimetableEntry::query()->create([
            'school_id' => $this->currentSchoolId(),
            ...$validated,
            'is_holiday' => (bool) ($validated['is_holiday'] ?? false),
        ]);

        return redirect()->route('portal.index')->with('success', 'Timetable entry saved successfully.');
    }

    public function storeResult(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string'],
            'standard_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'exam_name' => ['required', 'string', 'max:120'],
            'marks' => ['required', 'numeric', 'min:0', 'max:100'],
            'grade' => ['required', 'string', 'max:5'],
        ]);

        Result::query()->create([
            'school_id' => $this->currentSchoolId(),
            ...$validated,
            'published_at' => now()->toDateTimeString(),
        ]);

        return redirect()->route('portal.index')->with('success', 'Result uploaded successfully.');
    }

    public function storeNotice(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:1000'],
            'target_role' => ['required', 'string', 'max:30'],
            'scope' => ['required', 'in:school,all'],
        ]);

        $scope = $validated['scope'];
        $schoolId = $this->currentSchoolId(false);

        if ($scope === 'all' && $user->role !== 'superadmin') {
            $scope = 'school';
        }

        Notice::query()->create([
            'school_id' => $scope === 'all' ? null : $schoolId,
            'title' => $validated['title'],
            'message' => $validated['message'],
            'target_role' => $validated['target_role'],
            'scope' => $scope,
            'publish_at' => now()->toDateTimeString(),
            'created_by' => (string) $user->_id,
        ]);

        return redirect()->route('portal.index')->with('success', 'Notice published successfully.');
    }

    public function storeHoliday(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'date' => ['required', 'date'],
            'type' => ['required', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:250'],
        ]);

        Holiday::query()->create([
            'school_id' => $this->currentSchoolId(),
            ...$validated,
        ]);

        return redirect()->route('portal.index')->with('success', 'Holiday added successfully.');
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => ['required', 'in:student,teacher,staff'],
            'entity_id' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,leave'],
            'remark' => ['nullable', 'string', 'max:180'],
        ]);

        Attendance::query()->create([
            'school_id' => $this->currentSchoolId(),
            ...$validated,
        ]);

        return redirect()->route('portal.index')->with('success', 'Attendance saved successfully.');
    }

    private function currentSchoolId(bool $strict = true): ?string
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            return $strict ? null : null;
        }

        return (string) $user->school_id;
    }

    // Update methods
    public function updateStandard(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'order' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Standard::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Standard updated successfully.');
    }

    public function updateSubject(Request $request, $id)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:30'],
        ]);

        Subject::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Subject updated successfully.');
    }

    public function updateCourse(Request $request, $id)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:250'],
        ]);

        Course::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Course updated successfully.');
    }

    public function updateStaff(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:80'],
            'designation' => ['required', 'string', 'max:80'],
            'user_role' => ['required', 'string', 'max:50'],
        ]);

        StaffMember::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Staff member updated successfully.');
    }

    public function updateTimetable(Request $request, $id)
    {
        $validated = $request->validate([
            'standard_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'teacher_id' => ['nullable', 'string'],
            'day' => ['required', 'string', 'max:20'],
            'start_time' => ['required', 'string', 'max:10'],
            'end_time' => ['required', 'string', 'max:10'],
        ]);

        TimetableEntry::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Timetable entry updated successfully.');
    }

    public function updateResult(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string'],
            'standard_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'exam_name' => ['required', 'string', 'max:120'],
            'marks' => ['required', 'numeric', 'min:0', 'max:100'],
            'grade' => ['required', 'string', 'max:5'],
        ]);

        Result::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Result updated successfully.');
    }

    public function updateNotice(Request $request, $id)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:1000'],
            'target_role' => ['required', 'string', 'max:30'],
            'scope' => ['required', 'in:school,all'],
        ]);

        $scope = $validated['scope'];
        if ($scope === 'all' && $user->role !== 'superadmin') {
            $scope = 'school';
        }

        Notice::query()
            ->where('_id', $id)
            ->where('school_id', $user->role === 'superadmin' ? null : $this->currentSchoolId())
            ->firstOrFail()
            ->update([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'target_role' => $validated['target_role'],
                'scope' => $scope,
            ]);

        return redirect()->route('portal.index')->with('success', 'Notice updated successfully.');
    }

    public function updateHoliday(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'date' => ['required', 'date'],
            'type' => ['required', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:250'],
        ]);

        Holiday::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Holiday updated successfully.');
    }

    public function updateAttendance(Request $request, $id)
    {
        $validated = $request->validate([
            'entity_type' => ['required', 'in:student,teacher,staff'],
            'entity_id' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,leave'],
            'remark' => ['nullable', 'string', 'max:180'],
        ]);

        Attendance::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->update($validated);

        return redirect()->route('portal.index')->with('success', 'Attendance updated successfully.');
    }

    // Delete methods
    public function deleteStandard($id)
    {
        Standard::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Standard deleted successfully.');
    }

    public function deleteSubject($id)
    {
        Subject::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Subject deleted successfully.');
    }

    public function deleteCourse($id)
    {
        Course::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Course deleted successfully.');
    }

    public function deleteStaff($id)
    {
        StaffMember::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Staff member deleted successfully.');
    }

    public function deleteTimetable($id)
    {
        TimetableEntry::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Timetable entry deleted successfully.');
    }

    public function deleteResult($id)
    {
        Result::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Result deleted successfully.');
    }

    public function deleteNotice($id)
    {
        $user = auth()->user();

        Notice::query()
            ->where('_id', $id)
            ->where('school_id', $user->role === 'superadmin' ? null : $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Notice deleted successfully.');
    }

    public function deleteHoliday($id)
    {
        Holiday::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Holiday deleted successfully.');
    }

    public function deleteAttendance($id)
    {
        Attendance::query()
            ->where('_id', $id)
            ->where('school_id', $this->currentSchoolId())
            ->firstOrFail()
            ->delete();

        return redirect()->route('portal.index')->with('success', 'Attendance record deleted successfully.');
    }
}
