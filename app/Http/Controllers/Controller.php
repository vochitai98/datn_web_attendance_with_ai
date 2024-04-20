<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login()
    {
        return view('login');
    }
    public function loginHandle(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Kiểm tra xem username có tồn tại trong bảng admin không
        $admin = Admin::where('username', $username)->first();
        
        if ($admin) {
            if($password != $admin->password){
                return redirect()->route('login')->with('error', 'Password is not corect!');
            }
            // Nếu tồn tại trong bảng admin, đây là một admin
            session(['username' => $username]);
            return redirect()->route('admin_home');
        }

        // Kiểm tra xem username có tồn tại trong bảng student không
        $student = Student::where('username', $username)->first();
        if ($student) {
            if (!Hash::check($password, $student->password)) {
                return redirect()->route('login')->with('error', 'Student Password is not corect!');
            }
            // Nếu tồn tại trong bảng student, đây là một student
            session(['username' => $username]);
            return redirect()->route('student_home');
        }

        // Kiểm tra xem username có tồn tại trong bảng teacher không
        $teacher = Teacher::where('username', $username)->first();
        
        if ($teacher) {
            if (!Hash::check($password, $teacher->password)) {
                return redirect()->route('login')->with('error', 'Teacher Password is not corect!');
            }
            // Nếu tồn tại trong bảng teacher, đây là một teacher
            session(['username' => $username]);
            return redirect()->route('teacher_home');
        }
        // Nếu không tìm thấy trong bất kỳ bảng nào, chuyển hướng về trang đăng nhập với thông báo lỗi
        return redirect()->route('login')->with('error', 'Tên người dùng không tồn tại.');
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function checkValidatedRegister(Request $request)
    {
        $username = $request->input('username');

        // Kiểm tra xem username có tồn tại trong bất kỳ bảng nào không
        $adminExists = Admin::where('username', $username)->exists();
        $studentExists = Student::where('username', $username)->exists();
        $teacherExists = Teacher::where('username', $username)->exists();

        if ($adminExists || $studentExists || $teacherExists) {
            // Username đã tồn tại trong ít nhất một bảng
            return response()->json(['message' => 'Username already exists'], 400);
        }

        // Username không tồn tại trong bất kỳ bảng nào
        return response()->json(['message' => 'Username is available'], 200);
    }
    

}
