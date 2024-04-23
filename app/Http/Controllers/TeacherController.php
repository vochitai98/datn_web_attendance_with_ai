<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecords;
use Illuminate\Support\Facades\DB;
Use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Image;
use App\Models\Student;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function home()
    {
        return view('teacher.teacher_home');
    }

    public function attendanceManagement()
    {
        $username = session('username');
        $class = DB::table('classes')
        ->join('teachers', 'classes.teacher_id', '=', 'teachers.id')
        ->where('teachers.username', $username)
            ->select('classes.*')
            ->first();

        //if exist class
        if ($class) {
            $attendance_dates = DB::table('attendance_records')
            ->join('students', 'attendance_records.student_id', '=', 'students.id')
            ->where('students.class_id', $class->id)
            ->select('attendance_date')
            ->distinct()
            ->get();
        }
        return view('teacher.attendance_management',compact('class', 'attendance_dates'));
    }

    public function processAttendance(Request $request)
    {

        $name = $request->input('date');
        $image = $request->input('image');
        $className = '20TCLC DT5';
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'date' => 'required|date',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['message' => 'Validation failed', 'errors' => $e->validator->errors()], 422);
        }
        $base_url = 'http://localhost:8888/recognize';
        // Initialize Guzzle HTTP Client
        $client = new Client();
        // Send POST request to Flask API with file and username
        $response = $client->request('POST', $base_url, [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($validatedData['image']->path(), 'r'),
                ],
                [
                    'name'     => 'className',
                    'contents' => $className
                ]
            ]
        ]);
        $responseData = $response->getBody()->getContents();
        $username_attendance_list = json_decode($responseData, true);
        if ($response->getStatusCode() == 200) {
            $imagePath = $request->file('image')->storeAs('public/images/attendance', $request->file('image')->getClientOriginalName());
            $imageUrl = url(Storage::url($imagePath));

            $image = new Image();
            $image->image_url = $imageUrl;
            $image->save();

            $username = session('username');
            $class = DB::table('classes')
                ->join('teachers', 'classes.teacher_id', '=', 'teachers.id')
                ->where('teachers.username', $username)
                ->select('classes.*')
                ->first();
            if ($class) {
                $students = DB::table('students')
                    ->select('students.id','students.username')
                    ->where('class_id', $class->id)
                    ->get();
                foreach($students as $student){
                    $attendance_record = new AttendanceRecords();
                    $attendance_record->student_id = $student->id;
                    $attendance_record->image_id = $image->id;
                    $attendance_record->attendance_date = $validatedData['date'];
                    if (in_array($student->username, $username_attendance_list['text'])) {
                        $attendance_record->status = true;
                    } else {
                        $attendance_record->status = false;
                    }
                    $attendance_record->save();
                }
            }
            return response()->json(['message' => 'Attendance successfully!']);
        } else {
            return response()->json(['error' => 'Failed to upload image'], 500);
        }
        return view('teacher.attendance_management');
    }

    public function attendanceUser(Request $request)
    {
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $attendance_users = DB::table('attendance_records')
        ->where('student_id', $student_id)
        ->select('attendance_records.*')
        ->get();
        $class = DB::table('classes')->find($class_id);
        $student = DB::table('students')->find($student_id);
        return view('teacher.attendance_user', compact('attendance_users', 'class', 'student'));
    }

    public function attendanceUserList(Request $request)
    {
        $date = $request->input('attendance_date');
        $class_id = $request->input('class_id');
        $attendance_records = DB::table('attendance_records')
            ->join('students', 'students.id', '=', 'attendance_records.student_id')
            ->where('students.class_id', $class_id)
            ->where('attendance_records.attendance_date', $date)
            ->select('students.id', 'students.name', 'students.identification', 'students.phone', 'students.address', 'students.email', 'attendance_records.status', 'attendance_records.attendance_date')
            ->get();
        $class = DB::table('classes')->find($class_id);
        return view('teacher.attendance_user_list', compact('attendance_records','class'));
    }

    public function changePassword()
    {
        $username = session('username');
        return view('teacher.change_password', compact('username'));
    }

    public function editProfile()
    {
        $username = session('username');
        if (isset($username)) {
            $user = DB::table('teachers')
            ->where('username', $username)
                ->select('*')
                ->first();
            return view('teacher.edit_profile', compact('user'));
        }
        return view('teacher.edit_profile', compact('user'));
    }
}
