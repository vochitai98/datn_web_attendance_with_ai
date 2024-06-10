<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecords extends Model
{
    use HasFactory;
    protected $table = 'attendance_records';

    protected $fillable = ['student_id', 'status', 'attendance_date', 'active','image_id'];
}
