<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Http;
use App\Models\Classes;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function home()
    {
        $username = session('username');
        return view('student.student_home');
    }

    public function attendanceManagement(Request $request)
    {
        $username = session('username');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');

        $student = DB::table('students')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->where('username', $username)
            ->select('students.*','classes.name as className')
            ->first();

        // $attendance_records = DB::table('attendance_records')
        //     ->where('student_id', $student->id)
        //     ->select('attendance_records.*')
        //     ->get();
        $query = DB::table('attendance_records')
            ->join('images', 'attendance_records.image_id', '=', 'images.id')
            ->select('attendance_records.*','images.image_url')
            ->where('student_id', $student->id);
        
        if (isset($startDate)) {
            $query->where('attendance_date','>=', $startDate);
        }
        if (isset($endDate)) {
            $query->where('attendance_date', '<=', $endDate);
        }
        if (isset($status)) {
            $query->where('status', $status);
        }

        $attendance_records = $query->get();
        $absent_count = 0;
        foreach($attendance_records as $arc){
            if($arc->status == 0){
                $absent_count++;
            }
        }
        return view('student.attendance_management',compact('student', 'attendance_records','absent_count'));
    }

    public function register(Request $request)
    {
        return view('student.register');
    }

    public function registerNextPage(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'username' => 'required|string|max:255|unique:teachers,username|unique:students,username|unique:admin,username',
                'password' => 'required|string|min:6|max:255',
                'email' => 'required|email|unique:students,email|unique:teachers,email',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
        }
        if ($request->input('password') != $request->input('confirm_password')) {
            return redirect()->back()->with('errors', 'confirm password is not correct!');
        }
        session()->put('registration_data', $request->all());
        $registrationData = session()->get('registration_data');
        $classes = Classes::all();
        return view('student.register_next_page',compact('classes'))->with('registrationData', $registrationData);
    }

    public function registerHandle(Request $request)
    {
        $name = $request->input('name');
        $username = session('registration_data')['username'];
        $password = session('registration_data')['password'];
        $email = session('registration_data')['email'];

        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',  
                'phone' => 'required|string|max:15|unique:teachers,phone',
                'address' => 'nullable|string|max:255',
                'identification' => 'nullable|string',
                'dob' => 'required|date',
                'class_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'avt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
        }
        $base_url = 'http://localhost:8888/register';
        // Initialize Guzzle HTTP Client
        $client = new Client();
        // Send POST request to Flask API with file and username
        $response = $client->request('POST', $base_url, [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($validatedData['image']->path(), 'r'),
                    'filename' => $username.".jpg" // Use original filename
                ],
                [
                    'name'     => 'username',
                    'contents' => $username
                ],
                [
                    'name'     => 'classId',
                    'contents' => $validatedData['class_id']
                ]
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $user = new Student();
            $user->name = $name;
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->phone = $validatedData['phone'];
            $user->email = $email;
            $user->dayofbirth = $validatedData['dob'];
            $user->class_id = $validatedData['class_id'];
            $user->address = $validatedData['address'];
            $user->identification = $validatedData['identification'];
            $user->save();

            return redirect()->back()->with('message', 'User created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to upload image');
        }
    }


    public function changePassword()
    {
        $username = session('username');
        return view('student.change_password',compact('username'));
    }

    public function editProfile()
    {
        $username = session('username');
        $classes = Classes::all();
        if (isset($username)) {
            $user = DB::table('students')
            ->where('username', $username)
            ->select('*')
            ->first();
            return view('student.edit_profile', compact('user'));
        }
        return view('student.edit_profile', compact('user'));
    }
}
