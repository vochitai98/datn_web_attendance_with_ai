<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = ['name', 'username', 'password', 'email', 'phone', 'address', 'dayofbirth', 'identification','avt', 'gender'];

    protected $hidden = ['password'];

    public function class()
    {
        return $this->hasOne(Classes::class);
    }

}
