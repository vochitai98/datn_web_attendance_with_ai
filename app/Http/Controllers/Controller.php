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

    public function home()
    {
        return view('calender');
    }

    public function login()
    {
        return view('login');
    }
    public function loginHandle(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = Admin::where('username', $username)->first();
        
        if ($admin) {
            if(!Hash::check($password, $admin->password)){
                return redirect()->route('login')->with('error', 'Password is not corect!');
            }
            session(['username' => $username]);
            return redirect()->route('admin_home');
        }

        $student = Student::where('username', $username)->first();
        if ($student) {
            if (!Hash::check($password, $student->password)) {
                return redirect()->route('login')->with('error', 'Student Password is not corect!');
            }
            session(['username' => $username]);
            return redirect()->route('student_home');
        }
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

    public function checkValidatedRegister(Request $request)
    {
        $username = $request->input('username');
        $adminExists = Admin::where('username', $username)->exists();
        $studentExists = Student::where('username', $username)->exists();
        $teacherExists = Teacher::where('username', $username)->exists();

        if ($adminExists || $studentExists || $teacherExists) {
            return response()->json(['message' => 'Username already exists'], 400);
        }
        return response()->json(['message' => 'Username is available'], 200);
    }

    public function changePasswordHandle(Request $request)
    {
        $username = $request->input('username');
        //check username is what role
        $studentExists = Student::where('username', $username)->exists();
        $teacherExists = Teacher::where('username', $username)->exists();

        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');
        if (isset($username)) {
            if($studentExists){
                $user = Student::where('username', $username)->first();
            }else if($teacherExists){
                $user = Teacher::where('username', $username)->first();
            }else{
                $user = Admin::where('username', $username)->first();
            }
            if (password_verify($current_password, $user->password)) {
                if ($new_password == $confirm_password) {
                    $user->password = Hash::make($new_password);
                    $user->save();
                    // Return a success message and redirect to the login page
                    return redirect()->route('login')->with('success', 'Password changed successfully! Please login with your new password.');
                } else {
                    //return back with error message: New password does not match!
                    return back()->with('error', 'New password does not match!');
                }
            } else {
                //return back with error message: Current password is wrong!
                return back()->with('error', 'Current password is wrong!');
            }
        } else {
            //return back with error message: Username is not set!
            return back()->with('error', 'Username is not set!');
        }
    }
}
