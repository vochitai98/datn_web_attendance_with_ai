<?php

namespace App\Http\Controllers;


use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Student;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function home()
    {
        $username = session('username');
        $studentCounts = Student::get()->count();
        $teacherCounts = Teacher::get()->count();
        $classCounts = Classes::get()->count();
        return view('admin.admin_home',compact('studentCounts', 'teacherCounts', 'classCounts'));
    }

    public function classManagement(Request $request)
    {   
        $class_id = $request->input('class_id');
        $search = $request->input('search');
        if(isset($class_id)){
            try {
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
                // Check response status code to ensure success
                if ($response->getStatusCode() == 200) {
                    Classes::where('id', $class_id)->delete();
                    return redirect()->back()->with(['message' => 'Delete class successful.']);
                } else {
                    // Return error message if response status code is not 200
                    return redirect()->back()->with(['errors' => 'Delete class failed.'], $response->getStatusCode());
                }
            } catch (\Exception $e) {
                // Handle exception and return error message
                return redirect()->back()->with(['errors' => $e->getMessage()]);
            }
            
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
        $active = $request->input('active');
        $class_id = $request->input('class_id');
        $classes = DB::table('classes')->get();
        $search = $request->input('search');
        if (isset($student_id)) {
            $student = Student::find($student_id);
            try {
                $base_url = 'http://localhost:8888/deleteStudent';
                // Initialize Guzzle HTTP Client
                $client = new Client();
                // Send POST request to Flask API with file and username
                $response = $client->request('POST', $base_url, [
                    'multipart' => [
                        [
                            'name'     => 'username',
                            'contents' => $student->username
                        ],
                        [
                            'name'     => 'classId',
                            'contents' => $student->class_id
                        ],
                    ]
                ]);
                // Check response status code to ensure success
            } catch (\Exception $e) {
                return redirect()->back()->with(['errors' => $e->getMessage()]);
            }
            $student->delete();
            return redirect()->back()->with(['message' => "Student deleted successfully"]);
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

    public function classEditHandle(Request $request)
    {
        $class_id = $request->input('class_id');
        if($class_id){
            try {
                // Validate the incoming request data
                $validatedData = $request->validate([
                    'className' => 'required|string|max:255',
                    'teacher_id' => 'required|string|max:255|exists:teachers,id',
                    // Add validation rules for other fields
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Handle validation errors
                return redirect()->back()->with(['errors' => $e->validator->errors()]);
            }
            $class = Classes::findOrFail($class_id);
            $class->name = $validatedData['className'];
            $class->teacher_id = $validatedData['teacher_id'];
            $class->save();
            return redirect()->back()->with('message', 'Class updated successfully!');
        }
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'className' => 'required|string|max:255|unique:classes,name',
                'teacher_id' => 'required|string|max:255|exists:teachers,id|unique:classes,teacher_id',
                // Add validation rules for other fields
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
        }
        // Create a new resource instance
        $class = new Classes();
        $class->name = $validatedData['className'];
        $class->teacher_id = $validatedData['teacher_id'];
        // Thực hiện lưu vào cơ sở dữ liệu
        $class->save();
        try {
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
            // Check response status code to ensure success
        } catch (\Exception $e) {
            $class->delete();
            return redirect()->back()->with(['errors' => $e->getMessage()]);
        }
        return redirect()->back()->with('message', 'Class created successfully!');
    }

    public function teacherEditHandle(Request $request)
    {
        $username = $request->input('username');
        $id = $request->input('id');
        if(!isset($username)){
            $user = Teacher::where('id', $id)->first();
            try {
                // Validate the incoming request data
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'nullable|email|max:255|unique:teachers,email,' . $id . '|unique:students,email,' . $id,
                    'phone' => 'nullable|string|max:15|unique:teachers,phone,' . $id . '|unique:students,phone,' . $id,
                    'address' => 'nullable|string|max:255',
                    'identification' => 'nullable|string',
                    'dayofbirth' => 'nullable|date',
                    'gender' => 'required|boolean'
                    // Add validation rules for other fields
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Handle validation errors
                return redirect()->back()->with(['errors' => $e->validator->errors()]);
            }
        }else{
            try {
                // Validate the incoming request data
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'username' => 'required|string|max:255|unique:teachers,username|unique:students,username|unique:admin,username',
                    'email' => 'nullable|email|max:255|unique:teachers,email|unique:students,email',
                    'phone' => 'nullable|string|max:15|unique:teachers,phone|unique:students,phone',
                    'password' => 'required|string|min:6|max:255',
                    'address' => 'nullable|string|max:255',
                    'identification' => 'nullable|string',
                    'dayofbirth' => 'nullable|date',
                    // Add validation rules for other fields
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Handle validation errors
                return redirect()->back()->with(['errors' => $e->validator->errors()]);
            }
            $user = new Teacher();
            $user->username = $validatedData['username'];
            $user->password = Hash::make($validatedData['password']);
        }
        
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->dayofbirth = $validatedData['dayofbirth'];
        $user->address = $validatedData['address'];
        $user->identification = $validatedData['identification'];
        $user->gender = $validatedData['gender'];
        $user->save();
        if(isset($username)){
            return redirect()->back()->with('message', 'Teacher created successfully!');
        }
        return redirect()->back()->with('message', 'Teacher updated successfully!');
    }

    public function studentEditHandle(Request $request)
    {
        $id = $request->input('id');
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:teachers,email,' . $id . '|unique:students,email,' . $id,
                'phone' => 'nullable|string|max:15|unique:teachers,phone,' . $id . '|unique:students,phone,' . $id,
                'address' => 'nullable|string|max:255',
                'identification' => 'nullable|string',
                'class_id' => 'required|exists:classes,id',
                'dayofbirth' => 'nullable|date',
                'gender' => 'required|boolean',
                // Add validation rules for other fields
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
        }
        $user = Student::where('id', $id)->first();
        $old_class_id = $user->class_id;
        $new_class_id = $validatedData['class_id'];
        if($old_class_id != $new_class_id){
            try {
                $base_url = 'http://localhost:8888/updateStudentClass';
                // Initialize Guzzle HTTP Client
                $client = new Client();
                // Send POST request to Flask API with file and username
                $response = $client->request('POST', $base_url, [
                    'multipart' => [
                        [
                            'name'     => 'old_class_id',
                            'contents' => $old_class_id
                        ],
                        [
                            'name'     => 'new_class_id',
                            'contents' => $new_class_id
                        ],
                        [
                            'name'     => 'username',
                            'contents' => $user->username
                        ],
                    ]
                ]);
                // Check response status code to ensure success
            } catch (\Exception $e) {
                return redirect()->back()->with(['errors' => $e->getMessage()]);
            }
        }
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->dayofbirth = $validatedData['dayofbirth'];
        $user->address = $validatedData['address'];
        $user->identification = $validatedData['identification'];
        $user->gender = $validatedData['gender'];
        $user->class_id = $validatedData['class_id'];
        $user->save();
        return redirect()->back()->with('message', 'Student updated successfully!');
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

    public function toggleActive(Request $request)
    {
        $student = Student::find($request->student_id);

        if ($student) {
            // Toggle trạng thái active dựa trên giá trị hiện tại
            $student->active = !$request->active;
            $student->save();
            if(!$student->active){
                $student->active = 0;
            }
            // Trả về trạng thái mới sau khi cập nhật
            return response()->json([
                'success' => true,
                'active' => $student->active
            ]);
        }

        return response()->json(['success' => false], 400);
    }


}
