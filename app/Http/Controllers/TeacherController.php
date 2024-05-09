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

    public function attendanceManagement(Request $request)
    {
        $image_id = $request->input('image_id');
        if (isset($image_id)) {
            Image::where('id', $image_id)->delete();
        }
        $username = session('username');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $class = DB::table('classes')
        ->join('teachers', 'classes.teacher_id', '=', 'teachers.id')
        ->where('teachers.username', $username)
            ->select('classes.*')
            ->first();

        //if exist class
        if ($class) {
            $query = DB::table('attendance_records')
            ->join('students', 'attendance_records.student_id', '=', 'students.id')
            ->join('images', 'attendance_records.image_id', '=', 'images.id')
            ->where('students.class_id', $class->id)
            ->select('images.id as image_id','images.image_url', 'attendance_records.attendance_date')
            ->distinct();

        if (isset($startDate)) {
            $query->where('attendance_records.attendance_date', '>=', $startDate);
        }
        if(isset($endDate)){
            $query->where('attendance_records.attendance_date','<=', $endDate);
        }

        $attendance_dates = $query->get();
        }else{
            return view('teacher.attendance_management');
        }
        return view('teacher.attendance_management',compact('class', 'attendance_dates'));
    }

    public function takeAttendance(Request $request){
        $username = session('username');
        $class = DB::table('classes')
            ->join('teachers', 'classes.teacher_id', '=', 'teachers.id')
            ->where('teachers.username', $username)
            ->select('classes.*')
            ->first();
        return view('teacher.take_attendance',compact('class'));
    }

    public function processAttendance(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'date' => 'required|date',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'classId' => 'required|exists:classes,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->with(['errors' => $e->validator->errors()]);
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
                    'name'     => 'classId',
                    'contents' => $validatedData['classId']
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
            return redirect()->back()->with(['message' => 'Attendance successfully!']);
        } else {
            return redirect()->back()->with(['errors' => 'Failed to upload image']);
        }
        return view('teacher.attendance_management');
    }

    public function attendanceUserList(Request $request)
    {
        $search = $request->input('search');
        $statusSearch = $request->input('statusSearch');
        $date = $request->input('attendance_date');
        $class_id = $request->input('class_id');
        $query = DB::table('attendance_records')
            ->join('students', 'students.id', '=', 'attendance_records.student_id')
            ->where('students.class_id', $class_id)
            ->where('attendance_records.attendance_date', $date)
            ->select('students.id', 'students.name', 'students.identification', 'students.phone', 'students.address', 'students.email', 'attendance_records.status', 'attendance_records.attendance_date');
        if(isset($statusSearch)){
            $query->where('attendance_records.status',$statusSearch);
        }
        if (isset($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('students.name', 'like', '%' . $search . '%')
                ->orWhere('students.identification', 'like', '%' . $search . '%')
                ->orWhere('students.phone', 'like', '%' . $search . '%')
                ->orWhere('students.address', 'like', '%' . $search . '%')
                ->orWhere('students.email', 'like', '%' . $search . '%');
            });
        }
        $attendance_records = $query->get();
        $class = DB::table('classes')->find($class_id);
        return view('teacher.attendance_user_list', compact('attendance_records','class','date'));
    }

    public function attendanceUser(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $query = DB::table('attendance_records')
        ->where('student_id', $student_id)
            ->select('attendance_records.*');
        if (isset($startDate)) {
            $query->where('attendance_date', '>=', $startDate);
        }
        if (isset($endDate)) {
            $query->where('attendance_date', '<=', $endDate);
        }
        if (isset($status)) {
            $query->where('status', $status);
        }
        $attendance_users = $query->get();
        $class = DB::table('classes')->find($class_id);
        $student = DB::table('students')->find($student_id);
        return view('teacher.attendance_user', compact('attendance_users', 'class', 'student'));
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
