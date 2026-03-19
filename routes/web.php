<?php

use App\Http\Controllers\SchoolPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SchoolPortalController::class, 'index'])->name('portal.index');
Route::post('/teachers', [SchoolPortalController::class, 'storeTeacher'])->name('portal.teachers.store');
Route::post('/classes', [SchoolPortalController::class, 'storeClass'])->name('portal.classes.store');
Route::post('/students', [SchoolPortalController::class, 'storeStudent'])->name('portal.students.store');
