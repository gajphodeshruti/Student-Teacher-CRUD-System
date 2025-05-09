<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TeacherController;
use FontLib\Table\Type\post;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Facades\Captcha;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'index'])->name('register.view');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'loginView'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
// Route::get('/captcha/{config?}', function ($config = 'default') {
//     return Captcha::create($config);
// })->name('captcha');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('auth.index');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/get-districts/{id}', [StudentController::class, 'getDistricts'])->name('getDistricts');
Route::get('/get-talukas/{id}', [StudentController::class, 'getTalukas'])->name('getTalukas');


Route::get('/student-create',[StudentController::class,'create'])->name('Students.create');

Route::post('/student-store',[StudentController::class,'store'])->name('Students.store');

Route::get('/students/{id}/edit',[StudentController::class,'edit'])->name('students.edit');

Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('students.update'); // for form submission

Route::get('/search-index',[StudentController::class,'index'])->name('students.index');

Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export');

Route::get('/students/export/excel', [StudentController::class, 'exportExcel'])->name('students.export.excel');

Route::get('/student-autocomplete', [TeacherController::class, 'autocomplete'])->name('student.autocomplete');
// forgot-password

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

Route::get('/change-password', [ChangePasswordController::class, 'showChangeForm'])->name('password.change');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('password.update.loggedin');


Route::get('/profile', [AuthController::class, 'show'])->name('profile');
Route::post('/profile/upload', [AuthController::class, 'upload'])->name('profile.upload');

// Show the change password form
Route::get('/changepassword', [AuthController::class, 'showChangePasswordForm'])->name('change.password.form')->middleware('auth');

// Handle the password change logic
Route::post('/changepassword', [AuthController::class, 'changePassword'])->name('change.password')->middleware('auth');

Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');

Route::get('/teacher-create',[TeacherController::class,'create'])->name('teacher.create');

Route::post('/teacher-store',[TeacherController::class,'store'])->name('teacher.store');

Route::get('/get-university/{state_id}', [TeacherController::class, 'getuniversity'])->name('getuniversity');
Route::get('/get-college/{university_id}', [TeacherController::class, 'getcollege'])->name('getcollege');

Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('/teacher/{id}', [TeacherController::class, 'update'])->name('teacher.update'); // update should be PUT
Route::delete('/teacher/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');


Route::get('/teacher', [TeacherController::class, 'index1'])->name('teacher.index');

Route::get('/teachers/export/pdf', [TeacherController::class, 'exportPDF'])->name('teachers.export.pdf');

Route::get('/teachers/export/Excel', [TeacherController::class, 'exportExcel'])->name('teachers.export.excel');

Route::get('/teacher-autocomplete', [TeacherController::class, 'autocomplete'])->name('teacher.autocomplete');

Route::get('/superadmin-dashboard', [TeacherController::class, 'superadmin'])->name('auth.superadmin');

// In routes/web.php
Route::get('/user-counts', [AuthController::class, 'getUserCounts']);
