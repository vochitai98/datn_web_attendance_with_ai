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
//login page
Route::get('/login', [Controller::class, 'login'])->name('login');
Route::post('/login_handle', [Controller::class, 'loginHandle'])->name('login_handle');
Route::get('/change_password', [Controller::class, 'changePassword'])->name('change_password');
//router admin
Route::get('/admin', [AdminController::class, 'home'])->name('admin_home');
Route::get('/class_management', [AdminController::class, 'classManagement'])->name('admin.class_management');
Route::get('/teacher_management', [AdminController::class, 'teacherManagement'])->name('admin.teacher_management');
Route::get('/student_management', [AdminController::class, 'studentManagement'])->name('admin.student_management');
Route::get('/class_management/search_users', [AdminController::class, 'searchUsers'])->name('search_users');
Route::get('/class_edit', [AdminController::class, 'classEdit'])->name('admin.class_edit');
Route::get('/teacher_management/user_edit', [AdminController::class, 'userEdit'])->name('admin.user_edit');
Route::post('/teacher_management/user_add_handle', [AdminController::class, 'teacherAdd'])->name('admin.user_add_handle');
Route::post('/class_management/class_add_handle', [AdminController::class, 'classAdd'])->name('admin.class_add_handle');



//router student
Route::get('/student', [StudentController::class, 'home'])->name('student_home');
Route::get('/attendancnagement', [StudentController::class, 'attendanceManagement'])->name('student.attendance_management');
Route::get('/register', [StudentController::class, 'register'])->name('student.register');
Route::post('/register/next_page', [StudentController::class, 'registerNextPage'])->name('student.register_next_page');
Route::Post('/register_handle', [StudentController::class, 'registerHandle'])->name('student.register_handle');

//router teacher
Route::get('/teacher', [TeacherController::class, 'home'])->name('teacher_home');
Route::get('/attendance_management', [TeacherController::class, 'attendanceManagement'])->name('teacher.attendance_management');
Route::get('/attendance_management/attendance_user', [TeacherController::class, 'attendanceUser'])->name('teacher.attendance_user');
Route::get('/attendance_management/attendance_user/detail', [TeacherController::class, 'attendanceUserList'])->name('teacher.attendance_user_list');
Route::post('/process_attendance', [TeacherController::class, 'processAttendance'])->name('teacher.process_attendance');