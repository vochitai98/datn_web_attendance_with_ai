<?php

namespace App\Http\Controllers;


use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Student;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function home()
    {
        $username = session('username');
        return view('admin.admin_home');
    }

    public function classManagement(Request $request)
    {   
        $class_id = $request->input('class_id');
        $search = $request->input('search');
        if(isset($class_id)){
            $base_url = 'http://localhost:8888/deleteClass';
            // Initialize Guzzle HTTP Client
            $client = new Client();
            // Send POST request to Flask API with file and username
            $response = $client->request('POST', $base_url, [
                'multipart' => [
                    [
                        'name'     => 'classId',
                        'contents' => $class_id
                    ],
                ]
            ]);
            dd($class_id);exit;
            Classes::where('id',$class_id)->delete();
        }
        $query = DB::table('classes');
        if(isset($search)){
            $query->where('name','like','%'. $search .'%');
            $classes = $query->get();
            return view('admin.class_management', compact('classes','search'));
        }
        $classes = $query->get();
        return view('admin.class_management',compact('classes'));
    }

    public function teacherManagement(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        $search = $request->input('search');
        if (isset($teacher_id)) {
            Teacher::where('id', $teacher_id)->delete();
        }
        $query = DB::table('teachers')
        ->leftjoin('classes', 'teachers.id', '=', 'classes.teacher_id')
        ->select('teachers.*', 'classes.name as className');

        if (isset($search)) {
            $query->where('teachers.name', 'like', '%' . $search . '%')
            ->orWhere('teachers.identification', 'like', '%' . $search . '%')
            ->orWhere('classes.name', 'like', '%' . $search . '%')
            ->orWhere('teachers.phone', 'like', '%' . $search . '%')
            ->orWhere('teachers.address', 'like', '%' . $search . '%')
            ->orWhere('teachers.email', 'like', '%' . $search . '%');
            $teachers = $query->get();
            return view('admin.teacher_management', compact('teachers','search'));
        }
        $teachers = $query->get();
        return view('admin.teacher_management',compact('teachers'));
    }

    public function studentManagement(Request $request)
    {
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $classes = DB::table('classes')->get();
        $search = $request->input('search');
        if (isset($student_id)) {
            Student::where('id', $student_id)->delete();
        }
        $query = DB::table('students')
            ->join('classes', 'classes.id', '=', 'students.class_id')
            ->select('students.*','classes.name as className');
        if(isset($class_id)){
            $query->where('classes.id',$class_id);
        }
        if (isset($search)) {
            $query->where('students.name', 'like', '%' . $search . '%')
                ->orWhere('students.identification', 'like', '%' . $search . '%')
                ->orWhere('classes.name', 'like', '%' . $search . '%')
                ->orWhere('students.phone', 'like', '%' . $search . '%')
                ->orWhere('students.address', 'like', '%' . $search . '%')
                ->orWhere('students.email', 'like', '%' . $search . '%');
            $students = $query->get();
            return view('admin.student_management', compact('students', 'search', 'classes'));
        }
        $students = $query->get();
        return view('admin.student_management',compact('students', 'class_id', 'classes'));
    }

    public function teacherEdit(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        if(isset($teacher_id)){
            $teacher = DB::table('teachers')
                ->where('teachers.id', $teacher_id)
                ->select('teachers.*')
                ->first();
            return view('admin.teacher_edit', compact('teacher'));
        }
        return view('admin.teacher_edit');
    }


    public function studentEdit(Request $request)
    {
        $classes = Classes::all();
        $student_id = $request->input('student_id');
        if(isset($student_id)){
            $student = DB::table('students')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->where('students.id', $student_id)
                ->select('students.*', 'classes.name as className')
                ->first();
            return view('admin.student_edit',compact('student','classes'));
        }
        return view('admin.student_edit');
    }

    public function classEdit(Request $request)
    {
        $class_id = $request->input('class_id');
        $query = Teacher::leftJoin('classes', 'teachers.id', '=', 'classes.teacher_id')
        ->whereNull('classes.teacher_id');

        $class_id = $request->input('class_id');
        if (isset($class_id)) {
            $query->orWhere('classes.id', $class_id);
        }

        $teachers = $query->select('teachers.*')->get();
        if(isset($class_id)){
            $class = DB::table('classes')
                ->join('teachers', 'teachers.id', '=', 'classes.teacher_id')
                ->where('classes.id', $class_id)
                ->select('classes.*','teachers.name as teacherName')
                ->first();
            return view('admin.class_edit', compact('teachers','class'));
        }
        return view('admin.class_edit', compact('teachers'));
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
        $base_url = 'http://localhost:8888/addClass';
        // Initialize Guzzle HTTP Client
        $client = new Client();
        // Send POST request to Flask API with file and username
        $response = $client->request('POST', $base_url, [
            'multipart' => [
                [
                    'name'     => 'classId',
                    'contents' => $class->id
                ],
            ]
        ]);

        return response()->json(['message' => 'Class created successfully', 'data' => $class], 201);
    }

    public function teacherEditHandle(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:teachers,username|unique:students,username|unique:admin,username',
                'email' => 'required|email|unique:teachers,email',
                'phone' => 'nullable|string|max:15|unique:teachers,phone',
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

    public function studentEditHandle(Request $request)
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
        return response()->json(['message' => 'Student updated successfully', 'data' => $user], 201);
    }

    public function changePassword()
    {
        $username = session('username');
        return view('admin.change_password', compact('username'));
    }

    public function editProfile()
    {
        $username = session('username');
        $is_admin = true;
        if (isset($username)) {
            $user = DB::table('admin')
            ->where('admin.username', $username)
                ->select('*')
                ->first();
            return view('admin.edit_profile', compact('user','is_admin'));
        }
        return view('admin.edit_profile', compact('username'));
    }
}
