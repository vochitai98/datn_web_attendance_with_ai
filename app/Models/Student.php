<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = ['name', 'username', 'password', 'email', 'phone', 'address', 'dayofbirth', 'class_id', 'identification', 'avt', 'gender', 'active'];

    protected $hidden = ['password'];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
