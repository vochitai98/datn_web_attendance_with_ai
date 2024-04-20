<?php

namespace App\Http\Controllers;


use App\Models\Teacher;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function home()
    {
        $username = session('username');
        return view('admin.admin_home');
    }

    public function classManagement()
    {
        return view('admin.class_management');
    }

    public function teacherManagement()
    {
        // Xử lý yêu cầu liên quan đến quản lý người dùng ở đây
        return view('admin.teacher_management');
    }

    public function studentManagement()
    {
        // Xử lý yêu cầu liên quan đến quản lý người dùng ở đây
        return view('admin.student_management');
    }

    public function classEdit()
    {
        $teachers = Teacher::all();
        return view('admin.class_edit', compact('teachers'));
    }

    public function userEdit()
    {
        return view('admin.user_edit');
    }

    public function classAdd(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'className' => 'required|string|max:255|unique:classes,name',
                'teacher_id' => 'required|string|max:255|exists:teachers,id|unique:classes,teacher_id',
                // Add validation rules for other fields
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['message' => 'Validation failed', 'errors' => $e->validator->errors()], 422);
        }
        // Create a new resource instance
        $class = new Classes();
        $class->name = $validatedData['className'];
        $class->teacher_id = $validatedData['teacher_id'];
        // Thực hiện lưu vào cơ sở dữ liệu
        $class->save();
        return response()->json(['message' => 'Teacher created successfully', 'data' => $class], 201);
    }

    public function teacherAdd(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:teachers,username|unique:students,username|unique:admin,username',
                'email' => 'required|email|unique:teachers,email',
                'phone' => 'required|string|max:15|unique:teachers,phone',
                'password' => 'required|string|min:6|max:255',
                'address' => 'nullable|string|max:255',
                'identification' => 'nullable|string',
                'dayofbirth' => 'nullable|date',
                // Add validation rules for other fields
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['message' => 'Validation failed', 'errors' => $e->validator->errors()], 422);
        }
        // Create a new resource instance
        $user = new Teacher();
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->password = Hash::make($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->dayofbirth = $validatedData['dayofbirth'];
        $user->address = $validatedData['address'];
        $user->identification = $validatedData['identification'];
        // Thực hiện lưu vào cơ sở dữ liệu
        $user->save();
        return response()->json(['message' => 'Teacher created successfully', 'data' => $user], 201);
    }
}
