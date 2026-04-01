<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolPortalController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Resources\AttendanceResourceController;
use App\Http\Controllers\Resources\NoticeResourceController;
use App\Http\Controllers\Resources\SchoolResourceController;
use App\Http\Controllers\Resources\StaffMemberResourceController;
use App\Http\Controllers\Resources\StudentResourceController;
use App\Http\Controllers\Resources\TeacherResourceController;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	if (Auth::check()) {
		return redirect()->route('portal.index');
	}
	return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/setup/superadmin', [AuthController::class, 'bootstrapSuperAdmin'])->name('auth.bootstrap');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', function () {
		$user = Auth::user();
		if ($user && ($user->isSuperAdmin())) {
			return redirect()->route('superadmin.dashboard');
		}

		return redirect()->route('portal.school');
	})->name('portal.index');
	Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])
		->middleware('role:superadmin')
		->name('superadmin.dashboard');
	Route::get('/school', [SchoolPortalController::class, 'schoolPage'])->name('portal.school');

	Route::post('/schools', [SchoolPortalController::class, 'storeSchool'])
		->middleware('role:superadmin')
		->name('portal.schools.store');

	Route::post('/school-admins', [SchoolPortalController::class, 'storeSchoolAdmin'])
		->middleware('role:superadmin')
		->name('portal.school-admins.store');

	Route::post('/teachers', [SchoolPortalController::class, 'storeTeacher'])
		->middleware('role:admin,staff,teacher')
		->name('portal.teachers.store');

	Route::post('/classes', [SchoolPortalController::class, 'storeClass'])
		->middleware('role:admin,staff,teacher')
		->name('portal.classes.store');

	Route::post('/students', [SchoolPortalController::class, 'storeStudent'])
		->middleware('role:admin,staff,teacher')
		->name('portal.students.store');

	Route::post('/standards', [SchoolPortalController::class, 'storeStandard'])
		->middleware('role:admin,staff')
		->name('portal.standards.store');
	Route::patch('/standards/{id}', [SchoolPortalController::class, 'updateStandard'])
		->middleware('role:admin,staff')
		->name('portal.standards.update');
	Route::delete('/standards/{id}', [SchoolPortalController::class, 'deleteStandard'])
		->middleware('role:admin,staff')
		->name('portal.standards.delete');

	Route::post('/subjects', [SchoolPortalController::class, 'storeSubject'])
		->middleware('role:admin,staff')
		->name('portal.subjects.store');
	Route::patch('/subjects/{id}', [SchoolPortalController::class, 'updateSubject'])
		->middleware('role:admin,staff')
		->name('portal.subjects.update');
	Route::delete('/subjects/{id}', [SchoolPortalController::class, 'deleteSubject'])
		->middleware('role:admin,staff')
		->name('portal.subjects.delete');

	Route::post('/courses', [SchoolPortalController::class, 'storeCourse'])
		->middleware('role:admin,staff')
		->name('portal.courses.store');
	Route::patch('/courses/{id}', [SchoolPortalController::class, 'updateCourse'])
		->middleware('role:admin,staff')
		->name('portal.courses.update');
	Route::delete('/courses/{id}', [SchoolPortalController::class, 'deleteCourse'])
		->middleware('role:admin,staff')
		->name('portal.courses.delete');

	Route::post('/staff-members', [SchoolPortalController::class, 'storeStaff'])
		->middleware('role:admin,staff')
		->name('portal.staff.store');
	Route::patch('/staff-members/{id}', [SchoolPortalController::class, 'updateStaff'])
		->middleware('role:admin,staff')
		->name('portal.staff.update');
	Route::delete('/staff-members/{id}', [SchoolPortalController::class, 'deleteStaff'])
		->middleware('role:admin,staff')
		->name('portal.staff.delete');

	Route::post('/timetable', [SchoolPortalController::class, 'storeTimetable'])
		->middleware('role:admin,staff,teacher')
		->name('portal.timetable.store');
	Route::patch('/timetable/{id}', [SchoolPortalController::class, 'updateTimetable'])
		->middleware('role:admin,staff,teacher')
		->name('portal.timetable.update');
	Route::delete('/timetable/{id}', [SchoolPortalController::class, 'deleteTimetable'])
		->middleware('role:admin,staff,teacher')
		->name('portal.timetable.delete');

	Route::post('/results', [SchoolPortalController::class, 'storeResult'])
		->middleware('role:admin,staff,teacher')
		->name('portal.results.store');
	Route::patch('/results/{id}', [SchoolPortalController::class, 'updateResult'])
		->middleware('role:admin,staff,teacher')
		->name('portal.results.update');
	Route::delete('/results/{id}', [SchoolPortalController::class, 'deleteResult'])
		->middleware('role:admin,staff,teacher')
		->name('portal.results.delete');

	Route::post('/notices', [SchoolPortalController::class, 'storeNotice'])
		->middleware('role:superadmin,admin,staff')
		->name('portal.notices.store');
	Route::patch('/notices/{id}', [SchoolPortalController::class, 'updateNotice'])
		->middleware('role:superadmin,admin,staff')
		->name('portal.notices.update');
	Route::delete('/notices/{id}', [SchoolPortalController::class, 'deleteNotice'])
		->middleware('role:superadmin,admin,staff')
		->name('portal.notices.delete');

	Route::post('/holidays', [SchoolPortalController::class, 'storeHoliday'])
		->middleware('role:admin,staff')
		->name('portal.holidays.store');
	Route::patch('/holidays/{id}', [SchoolPortalController::class, 'updateHoliday'])
		->middleware('role:admin,staff')
		->name('portal.holidays.update');
	Route::delete('/holidays/{id}', [SchoolPortalController::class, 'deleteHoliday'])
		->middleware('role:admin,staff')
		->name('portal.holidays.delete');

	Route::post('/attendance', [SchoolPortalController::class, 'storeAttendance'])
		->middleware('role:admin,staff,teacher')
		->name('portal.attendance.store');
	Route::patch('/attendance/{id}', [SchoolPortalController::class, 'updateAttendance'])
		->middleware('role:admin,staff,teacher')
		->name('portal.attendance.update');
	Route::delete('/attendance/{id}', [SchoolPortalController::class, 'deleteAttendance'])
		->middleware('role:admin,staff,teacher')
		->name('portal.attendance.delete');

	Route::post('/profile/update', [ProfileController::class, 'update'])->name('portal.profile.update');
	Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('portal.password.update');

	Route::prefix('resources')->name('resources.')->group(function () {
		Route::resource('schools', SchoolResourceController::class);
		Route::resource('teachers', TeacherResourceController::class);
		Route::resource('students', StudentResourceController::class);
		Route::resource('staff-members', StaffMemberResourceController::class)->parameters(['staff-members' => 'id']);
		Route::resource('notices', NoticeResourceController::class);
		Route::resource('attendance', AttendanceResourceController::class);
	});

	// Communication Routes
	Route::get('/messages', [CommunicationController::class, 'getMessages'])
		->name('communication.messages.index');
	Route::post('/messages/send', [CommunicationController::class, 'sendMessage'])
		->name('communication.messages.send');
	Route::patch('/messages/{id}/read', [CommunicationController::class, 'markMessageAsRead'])
		->name('communication.messages.read');
	Route::delete('/messages/{id}', [CommunicationController::class, 'deleteMessage'])
		->name('communication.messages.delete');

	Route::get('/announcements', [CommunicationController::class, 'getAnnouncements'])
		->name('communication.announcements.index');
	Route::post('/announcements', [CommunicationController::class, 'createAnnouncement'])
		->middleware('role:superadmin,admin,staff')
		->name('communication.announcements.store');
	Route::delete('/announcements/{id}', [CommunicationController::class, 'deleteAnnouncement'])
		->middleware('role:superadmin,admin,staff')
		->name('communication.announcements.delete');

	Route::post('/files/upload', [CommunicationController::class, 'uploadFile'])
		->name('communication.files.upload');
	Route::get('/files', [CommunicationController::class, 'getFiles'])
		->name('communication.files.index');
	Route::get('/files/{id}/download', [CommunicationController::class, 'downloadFile'])
		->name('communication.files.download');
	Route::delete('/files/{id}', [CommunicationController::class, 'deleteFile'])
		->name('communication.files.delete');

	Route::get('/communication/stats', [CommunicationController::class, 'getStats'])
		->name('communication.stats');

	// Dashboard Analytics Routes
	Route::get('/api/stats', [DashboardController::class, 'getStats'])
		->name('dashboard.stats');
	Route::get('/api/students-by-standard', [DashboardController::class, 'getStudentsByStandard'])
		->name('dashboard.students.standard');
	Route::get('/api/attendance-trend', [DashboardController::class, 'getAttendanceTrend'])
		->name('dashboard.attendance.trend');
	Route::get('/api/results-distribution', [DashboardController::class, 'getResultsDistribution'])
		->name('dashboard.results.distribution');
	Route::get('/api/teacher-workload', [DashboardController::class, 'getTeacherWorkload'])
		->middleware('role:superadmin,admin,staff')
		->name('dashboard.teacher.workload');
	Route::get('/api/upcoming-holidays', [DashboardController::class, 'getUpcomingHolidays'])
		->name('dashboard.holidays.upcoming');
	Route::get('/api/notices', [DashboardController::class, 'getNotices'])
		->name('dashboard.notices');
	Route::get('/reports/summary', [DashboardController::class, 'getReportSummary'])
		->middleware('role:superadmin,admin,staff,teacher')
		->name('dashboard.reports.summary');
	Route::get('/reports/results/export', [DashboardController::class, 'exportResultsCsv'])
		->middleware('role:superadmin,admin,staff,teacher')
		->name('dashboard.reports.results.export');
	Route::get('/reports/attendance/export', [DashboardController::class, 'exportAttendanceCsv'])
		->middleware('role:superadmin,admin,staff,teacher')
		->name('dashboard.reports.attendance.export');
		
	Route::prefix('modules')->name('modules.')->group(function () {
		Route::resource('wallet', \App\Http\Controllers\Modules\Wallet\WalletController::class);
		Route::resource('documents', \App\Http\Controllers\Modules\Documents\DocumentsController::class);
		Route::resource('alumni', \App\Http\Controllers\Modules\Alumni\AlumniController::class);
		Route::resource('analytics', \App\Http\Controllers\Modules\Analytics\AnalyticsController::class);
		Route::resource('realtime', \App\Http\Controllers\Modules\Realtime\RealtimeController::class);
		Route::resource('finance-hr', \App\Http\Controllers\Modules\FinanceHr\FinanceHrController::class)->parameters(['finance-hr' => 'id']);

		Route::get('calendar', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'index'])->name('calendar.index');
		Route::get('calendar/create', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'create'])->name('calendar.create');
		Route::get('calendar/{id}', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'show'])->name('calendar.show');
		Route::get('calendar/{id}/edit', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'edit'])->name('calendar.edit');
		Route::post('calendar', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'store'])->name('calendar.store');
		Route::put('calendar/{id}', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'update'])->name('calendar.update');
		Route::delete('calendar/{id}', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'destroy'])->name('calendar.destroy');
		Route::post('calendar/tasks', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'taskStore'])->name('calendar.tasks.store');
		Route::put('calendar/tasks/{id}', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'taskUpdate'])->name('calendar.tasks.update');
		Route::delete('calendar/tasks/{id}', [\App\Http\Controllers\Modules\Calendar\CalendarController::class, 'taskDestroy'])->name('calendar.tasks.destroy');
	});

	Route::get('/attendance/ai', [\App\Http\Controllers\AttendanceController::class, 'aiAttendance'])->name('attendance.ai');
	Route::get('/grading/ai', [\App\Http\Controllers\GradingController::class, 'aiGrading'])->name('grading.ai');
	Route::get('/gamification/leaderboard', [\App\Http\Controllers\GamificationController::class, 'leaderboard'])->name('gamification.leaderboard');
});
