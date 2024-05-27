<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('false', function () {
    return view('student.false');
})->name('student.false');
//login page
Route::get('/login', [Controller::class, 'login'])->name('login');
Route::post('/login_handle', [Controller::class, 'loginHandle'])->name('login_handle');
Route::post('/change_password_handle', [Controller::class, 'changePasswordHandle'])->name('change_password_handle');
Route::post('/edit_profile_handle', [Controller::class, 'editProfileHandle'])->name('edit_profile_handle');
Route::get('/reset_password', [Controller::class, 'resetPassword'])->name('reset_password');
Route::get('/forgot_password', [Controller::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot_password_handle', [Controller::class, 'forgotPasswordHandle'])->name('forgot_password_handle');



Route::get('/home', [Controller::class, 'home'])->name('home');
//router admin
Route::get('/admin', [AdminController::class, 'home'])->name('admin_home');
Route::get('/class_management', [AdminController::class, 'classManagement'])->name('admin.class_management');
Route::get('/class_edit', [AdminController::class, 'classEdit'])->name('admin.class_edit');
Route::get('/teacher_management', [AdminController::class, 'teacherManagement'])->name('admin.teacher_management');
Route::get('/student_management', [AdminController::class, 'studentManagement'])->name('admin.student_management');
Route::get('/class_management/search_users', [AdminController::class, 'searchUsers'])->name('search_users');
Route::get('/teacher_management/teacher_edit', [AdminController::class, 'teacherEdit'])->name('admin.teacher_edit');
Route::get('/student_management/student_edit', [AdminController::class, 'studentEdit'])->name('admin.student_edit');
Route::post('/student_management/student_edit_handle', [AdminController::class, 'studentEditHandle'])->name('admin.student_edit_handle');
Route::post('/teacher_management/teacher_edit_handle', [AdminController::class, 'teacherEditHandle'])->name('admin.teacher_edit_handle');
Route::post('/toggle_active', [AdminController::class, 'toggleActive'])->name('admin.toggle_active');

Route::post('/class_management/class_add_handle', [AdminController::class, 'classEditHandle'])->name('admin.class_add_handle');
Route::get('/admin_change_password', [AdminController::class, 'changePassword'])->name('admin.change_password');
Route::get('/admin_edit_profile', [AdminController::class, 'editProfile'])->name('admin.edit_profile');

//router student
Route::get('/student', [StudentController::class, 'home'])->name('student_home');
Route::get('/attendancnagement', [StudentController::class, 'attendanceManagement'])->name('student.attendance_management');
Route::get('/register', [StudentController::class, 'register'])->name('student.register');
Route::post('/register/next_page', [StudentController::class, 'registerNextPage'])->name('student.register_next_page');
Route::post('/register_handle', [StudentController::class, 'registerHandle'])->name('student.register_handle');
Route::get('/student_change_password', [StudentController::class, 'changePassword'])->name('student.change_password');
Route::get('/student_edit_profile', [StudentController::class, 'editProfile'])->name('student.edit_profile');


//router teacher
Route::get('/teacher', [TeacherController::class, 'home'])->name('teacher_home');
Route::get('/attendance_management', [TeacherController::class, 'attendanceManagement'])->name('teacher.attendance_management');
Route::get('/attendance_management/attendance_user', [TeacherController::class, 'attendanceUser'])->name('teacher.attendance_user');
Route::get('/attendance_management/attendance_user/detail', [TeacherController::class, 'attendanceUserList'])->name('teacher.attendance_user_list');
Route::post('/process_attendance', [TeacherController::class, 'processAttendance'])->name('teacher.process_attendance');
Route::get('/take_attendance', [TeacherController::class, 'takeAttendance'])->name('teacher.take_attendance');
Route::get('/teacher_change_password', [TeacherController::class, 'changePassword'])->name('teacher.change_password');
Route::get('/teacher_edit_profile', [TeacherController::class, 'editProfile'])->name('teacher.edit_profile');

