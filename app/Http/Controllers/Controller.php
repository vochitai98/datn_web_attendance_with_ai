<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            session(['username' => $username, 'avt' => $student->avt]);
            return redirect()->route('student_home');
        }
        $teacher = Teacher::where('username', $username)->first();
        
        if ($teacher) {
            if (!Hash::check($password, $teacher->password)) {
                return redirect()->route('login')->with('error', 'Teacher Password is not corect!');
            }
            $class = Classes::where('teacher_id',$teacher->id)->first();
            session(['username' => $username, 'avt' => $teacher->avt, 'className' => $class->name]);
            return redirect()->route('teacher_home');
        }
        // Nếu không tìm thấy trong bất kỳ bảng nào, chuyển hướng về trang đăng nhập với thông báo lỗi
        return redirect()->route('login')->with('error', 'Username is not exists');
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

    public function editProfileHandle(Request $request)
    {
        $username = $request->input('username');
        //check username is what role
        $studentExists = Student::where('username', $username)->exists();
        $teacherExists = Teacher::where('username', $username)->exists();
        if ($studentExists) {
            $user = Student::where('username', $username)->first();
        } else if ($teacherExists) {
            $user = Teacher::where('username', $username)->first();
        } else {
            $user = Admin::where('username', $username)->first();
        }
        $userId = $user->id; 
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:teachers,email,' . $userId . '|unique:students,email,' . $userId,
                'phone' => 'nullable|string|max:15|unique:teachers,phone,' . $userId . '|unique:students,phone,' . $userId,
                'address' => 'nullable|string|max:255',
                'identification' => 'nullable|string',
                'dayofbirth' => 'nullable|date',
                'avt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                // Add validation rules for other fields
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
        }

        if (isset($username)) {
            if ($studentExists) {
                $user = Student::where('username', $username)->first();
                $user->name = $validatedData['name'];
                $user->email = $validatedData['email'];
                $user->phone = $validatedData['phone'];
                $user->address = $validatedData['address'];
                $user->dayofbirth = $validatedData['dayofbirth'];
                $user->identification = $validatedData['identification'];

            } else if ($teacherExists) {
                $user = Teacher::where('username', $username)->first();
                $user->name = $validatedData['name'];
                $user->phone = $validatedData['phone'];
                $user->address = $validatedData['address'];
                $user->dayofbirth = $validatedData['dayofbirth'];
                $user->identification = $validatedData['identification'];

            } else {
                $user = Admin::where('username', $username)->first();
                $user->name = $validatedData['name'];

            }
            if ($request->hasFile('avt')) {
                $imagePath = $request->file('avt')->store('public/images/avt');
                $imageUrl = Storage::url($imagePath);
                $imageUrl = str_replace('/storage', 'storage', Storage::url($imagePath));
                $user->avt = $imageUrl;
            }
            $user->save();
            return redirect()->back()->with('message', 'updated successfully!');
        }
        return redirect()->back()->with(['errors' => 'Username is not exists']);
    }
    public function resetPassword(Request $request){
        $username = $request->input('username');
        $email = $request->input('email');
        $studentExists = Student::where('username', $username)->exists();
        $teacherExists = Teacher::where('username', $username)->exists();
        if ($studentExists) {
            $user = Student::where('username', $username)->first();
        } else if ($teacherExists) {
            $user = Teacher::where('username', $username)->first();
        } else {
            return redirect()->back()->with(['errors' => 'Username is not exists']);
        }
        $newPassword = '123456';
        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::send('email_newpassword', ['password' => $newPassword], function ($message) use ($email) {
            $message->to($email)->subject('Your New Password');
        });
        return redirect()->back()->with(['message' => 'New password sent successfully']);
    }

    public function forgotPassword(){
        return view('forgot_password');
    }

    public function forgotPasswordHandle()
    {
        return view('forgot_password');
    }
}
