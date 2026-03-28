<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolPortalController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\DashboardController;
use App\Models\School;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	if (auth()->check()) {
		return redirect()->route('portal.index');
	}
	return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/setup/superadmin', [AuthController::class, 'bootstrapSuperAdmin'])->name('auth.bootstrap');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', [SchoolPortalController::class, 'index'])->name('portal.index');
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
		
	Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
	Route::get('/analytics/at-risk-students', [\App\Http\Controllers\AnalyticsController::class, 'atRiskStudents'])->name('analytics.at_risk_students');
	Route::get('/alumni', [\App\Http\Controllers\AlumniController::class, 'index'])->name('alumni.index');
	Route::get('/attendance/ai', [\App\Http\Controllers\AttendanceController::class, 'aiAttendance'])->name('attendance.ai');
	Route::get('/grading/ai', [\App\Http\Controllers\GradingController::class, 'aiGrading'])->name('grading.ai');
	Route::get('/gamification/leaderboard', [\App\Http\Controllers\GamificationController::class, 'leaderboard'])->name('gamification.leaderboard');
	Route::get('/realtime/gps-webrtc', [\App\Http\Controllers\RealtimeController::class, 'gpsWebrtc'])->name('realtime.gps_webrtc');
	Route::get('/documents/vault', [\App\Http\Controllers\DocumentsController::class, 'vault'])->name('documents.vault');
	Route::get('/finance-hr', [\App\Http\Controllers\FinanceHrController::class, 'index'])->name('finance_hr.index');
	Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
});
