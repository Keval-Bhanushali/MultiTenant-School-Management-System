<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Course;
use App\Models\StaffMember;
use App\Models\TimetableEntry;
use App\Models\Result;
use App\Models\Notice;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private function currentSchoolId(): ?string
    {
        $user = auth()->user();
        return $user->role === 'superadmin' ? null : (string) $user->school_id;
    }

    public function getStats()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $stats = [
            'total_schools' => 0,
            'total_users' => 0,
            'total_students' => 0,
            'total_teachers' => 0,
            'total_staff' => 0,
            'total_standards' => 0,
            'total_subjects' => 0,
            'total_courses' => 0,
            'total_timetables' => 0,
            'total_results' => 0,
            'total_attendance' => 0,
            'average_attendance_rate' => 0,
            'pass_fail_stats' => [],
        ];

        if ($user->role === 'superadmin') {
            $stats['total_schools'] = School::query()->count();
            $stats['total_users'] = User::query()->count();
        }

        // Role-specific queries
        $stats['total_students'] = User::query()
            ->where('role', 'student')
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_teachers'] = User::query()
            ->where('role', 'teacher')
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_staff'] = User::query()
            ->where('role', 'staff')
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_standards'] = Standard::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_subjects'] = Subject::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_courses'] = Course::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_timetables'] = TimetableEntry::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_results'] = Result::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        $stats['total_attendance'] = Attendance::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        // Attendance rate calculation
        $totalAttendance = Attendance::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        if ($totalAttendance > 0) {
            $presentCount = Attendance::query()
                ->where('status', 'present')
                ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
                ->count();
            $stats['average_attendance_rate'] = round(($presentCount / $totalAttendance) * 100, 2);
        }

        // Pass/Fail statistics
        $totalResults = Result::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->count();

        if ($totalResults > 0) {
            $passCount = Result::query()
                ->where('marks', '>=', 40)
                ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
                ->count();
            $failCount = $totalResults - $passCount;

            $stats['pass_fail_stats'] = [
                'passed' => $passCount,
                'failed' => $failCount,
                'pass_rate' => round(($passCount / $totalResults) * 100, 2),
                'fail_rate' => round(($failCount / $totalResults) * 100, 2),
            ];
        }

        return response()->json($stats);
    }

    public function getStudentsByStandard()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $standardData = Standard::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get()
            ->map(function ($standard) use ($schoolId) {
                $studentCount = User::query()
                    ->where('role', 'student')
                    ->where('standard_id', $standard->_id)
                    ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
                    ->count();

                return [
                    'standard' => $standard->name,
                    'student_count' => $studentCount,
                ];
            });

        return response()->json($standardData);
    }

    public function getAttendanceTrend()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $attendanceByDate = Attendance::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get()
            ->groupBy(function ($record) {
                return $record->created_at->format('Y-m-d');
            })
            ->map(function ($group) {
                $total = $group->count();
                $present = $group->where('status', 'present')->count();
                return [
                    'date' => $group->first()->created_at->format('Y-m-d'),
                    'present' => $present,
                    'absent' => $total - $present,
                    'rate' => round(($present / $total) * 100, 2),
                ];
            })
            ->sortBy('date')
            ->values();

        return response()->json($attendanceByDate);
    }

    public function getResultsDistribution()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $distributionRanges = [
            '90-100' => 0,
            '80-89' => 0,
            '70-79' => 0,
            '60-69' => 0,
            '50-59' => 0,
            'Below 50' => 0,
        ];

        Result::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get()
            ->each(function ($result) use (&$distributionRanges) {
                $marks = $result->marks ?? 0;
                if ($marks >= 90) {
                    $distributionRanges['90-100']++;
                } elseif ($marks >= 80) {
                    $distributionRanges['80-89']++;
                } elseif ($marks >= 70) {
                    $distributionRanges['70-79']++;
                } elseif ($marks >= 60) {
                    $distributionRanges['60-69']++;
                } elseif ($marks >= 50) {
                    $distributionRanges['50-59']++;
                } else {
                    $distributionRanges['Below 50']++;
                }
            });

        return response()->json($distributionRanges);
    }

    public function getTeacherWorkload()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        if (!in_array($user->role, ['superadmin', 'admin', 'staff'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $teacherWorkload = User::query()
            ->where('role', 'teacher')
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get()
            ->map(function ($teacher) {
                $timetableCount = TimetableEntry::query()
                    ->where('teacher_id', $teacher->_id)
                    ->count();
                $resultCount = Result::query()
                    ->where('teacher_id', $teacher->_id)
                    ->count();
                $attendanceCount = Attendance::query()
                    ->where('teacher_id', $teacher->_id)
                    ->count();

                return [
                    'teacher_name' => $teacher->name,
                    'email' => $teacher->email,
                    'timetable_entries' => $timetableCount,
                    'result_entries' => $resultCount,
                    'attendance_records' => $attendanceCount,
                    'total_load' => $timetableCount + $resultCount + $attendanceCount,
                ];
            });

        return response()->json($teacherWorkload);
    }

    public function getUpcomingHolidays()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $holidays = Holiday::query()
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit(10)
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get()
            ->map(fn($h) => [
                'name' => $h->name,
                'start_date' => $h->start_date->format('Y-m-d'),
                'end_date' => $h->end_date->format('Y-m-d'),
                'days' => $h->end_date->diffInDays($h->start_date) + 1,
            ]);

        return response()->json($holidays);
    }

    public function getNotices()
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        $notices = Notice::query()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get();

        return response()->json($notices);
    }

    public function getReportSummary(Request $request)
    {
        $schoolId = $this->currentSchoolId();

        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'standard_id' => ['nullable', 'string'],
        ]);

        $from = isset($validated['from']) ? Carbon::parse($validated['from'])->startOfDay() : null;
        $to = isset($validated['to']) ? Carbon::parse($validated['to'])->endOfDay() : null;

        $resultsQuery = Result::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->when($validated['standard_id'] ?? null, fn($q, $standardId) => $q->where('standard_id', $standardId));

        if ($from && $to) {
            $resultsQuery->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            $resultsQuery->where('created_at', '>=', $from);
        } elseif ($to) {
            $resultsQuery->where('created_at', '<=', $to);
        }

        $results = $resultsQuery->get();
        $totalResults = $results->count();
        $passCount = $results->where('marks', '>=', 40)->count();
        $avgMarks = $totalResults > 0 ? round($results->avg('marks'), 2) : 0;

        $attendanceQuery = Attendance::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId));

        if ($from && $to) {
            $attendanceQuery->whereBetween('date', [$from->toDateString(), $to->toDateString()]);
        } elseif ($from) {
            $attendanceQuery->where('date', '>=', $from->toDateString());
        } elseif ($to) {
            $attendanceQuery->where('date', '<=', $to->toDateString());
        }

        $attendance = $attendanceQuery->get();
        $totalAttendance = $attendance->count();
        $presentCount = $attendance->where('status', 'present')->count();

        $students = Student::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get(['_id', 'name'])
            ->keyBy('_id');

        $subjects = Subject::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get(['_id', 'name'])
            ->keyBy('_id');

        $standards = Standard::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get(['_id', 'name'])
            ->keyBy('_id');

        $topPerformers = $results
            ->sortByDesc('marks')
            ->take(5)
            ->map(function ($result) use ($students) {
                $student = $students->get((string) $result->student_id);

                return [
                    'student' => $student->name ?? 'Unknown',
                    'exam' => $result->exam_name,
                    'marks' => $result->marks,
                    'grade' => $result->grade,
                ];
            })
            ->values();

        $subjectPerformance = $results
            ->groupBy(function ($result) {
                return (string) $result->subject_id;
            })
            ->map(function ($items, $subjectId) use ($subjects) {
                $total = $items->count();
                $pass = $items->where('marks', '>=', 40)->count();
                $subject = $subjects->get($subjectId);

                return [
                    'subject' => $subject->name ?? 'Unknown',
                    'total_results' => $total,
                    'average_marks' => $total > 0 ? round($items->avg('marks'), 2) : 0,
                    'pass_rate' => $total > 0 ? round(($pass / $total) * 100, 2) : 0,
                ];
            })
            ->sortByDesc('average_marks')
            ->take(8)
            ->values();

        $standardPerformance = $results
            ->groupBy(function ($result) {
                return (string) $result->standard_id;
            })
            ->map(function ($items, $standardId) use ($standards) {
                $total = $items->count();
                $pass = $items->where('marks', '>=', 40)->count();
                $standard = $standards->get($standardId);

                return [
                    'standard' => $standard->name ?? 'Unknown',
                    'total_results' => $total,
                    'average_marks' => $total > 0 ? round($items->avg('marks'), 2) : 0,
                    'pass_rate' => $total > 0 ? round(($pass / $total) * 100, 2) : 0,
                ];
            })
            ->sortBy('standard')
            ->values();

        $monthlyTrend = $results
            ->groupBy(function ($result) {
                if (!$result->created_at) {
                    return 'Unknown';
                }

                return Carbon::parse($result->created_at)->format('Y-m');
            })
            ->map(function ($items, $month) {
                return [
                    'month' => $month,
                    'total_results' => $items->count(),
                    'average_marks' => round($items->avg('marks') ?? 0, 2),
                ];
            })
            ->sortBy('month')
            ->values();

        return response()->json([
            'total_results' => $totalResults,
            'pass_rate' => $totalResults > 0 ? round(($passCount / $totalResults) * 100, 2) : 0,
            'average_marks' => $avgMarks,
            'total_attendance' => $totalAttendance,
            'attendance_rate' => $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0,
            'top_performers' => $topPerformers,
            'subject_performance' => $subjectPerformance,
            'standard_performance' => $standardPerformance,
            'monthly_trend' => $monthlyTrend,
        ]);
    }

    public function exportResultsCsv(Request $request)
    {
        $schoolId = $this->currentSchoolId();

        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'standard_id' => ['nullable', 'string'],
        ]);

        $from = isset($validated['from']) ? Carbon::parse($validated['from'])->startOfDay() : null;
        $to = isset($validated['to']) ? Carbon::parse($validated['to'])->endOfDay() : null;

        $resultsQuery = Result::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->when($validated['standard_id'] ?? null, fn($q, $standardId) => $q->where('standard_id', $standardId));

        if ($from && $to) {
            $resultsQuery->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            $resultsQuery->where('created_at', '>=', $from);
        } elseif ($to) {
            $resultsQuery->where('created_at', '<=', $to);
        }

        $results = $resultsQuery->orderBy('created_at', 'desc')->get();

        $students = Student::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get(['_id', 'name'])
            ->keyBy('_id');

        $standards = Standard::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->get(['_id', 'name'])
            ->keyBy('_id');

        $filename = 'results_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($results, $students, $standards) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Student', 'Standard', 'Exam', 'Marks', 'Grade', 'Published At']);

            foreach ($results as $result) {
                $student = $students->get((string) $result->student_id);
                $standard = $standards->get((string) $result->standard_id);

                fputcsv($handle, [
                    $student->name ?? 'Unknown',
                    $standard->name ?? 'Unknown',
                    $result->exam_name,
                    $result->marks,
                    $result->grade,
                    optional($result->created_at)->format('Y-m-d H:i:s') ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportAttendanceCsv(Request $request)
    {
        $schoolId = $this->currentSchoolId();

        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'entity_type' => ['nullable', 'in:student,teacher,staff'],
        ]);

        $from = isset($validated['from']) ? Carbon::parse($validated['from'])->toDateString() : null;
        $to = isset($validated['to']) ? Carbon::parse($validated['to'])->toDateString() : null;

        $attendanceQuery = Attendance::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->when($validated['entity_type'] ?? null, fn($q, $entityType) => $q->where('entity_type', $entityType));

        if ($from && $to) {
            $attendanceQuery->whereBetween('date', [$from, $to]);
        } elseif ($from) {
            $attendanceQuery->where('date', '>=', $from);
        } elseif ($to) {
            $attendanceQuery->where('date', '<=', $to);
        }

        $attendanceRecords = $attendanceQuery->orderBy('date', 'desc')->get();

        $filename = 'attendance_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($attendanceRecords) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Entity Type', 'Entity ID', 'Status', 'Remark']);

            foreach ($attendanceRecords as $record) {
                fputcsv($handle, [
                    $record->date,
                    $record->entity_type,
                    $record->entity_id,
                    $record->status,
                    $record->remark ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
