<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['teacher_id', 'name', 'phone', 'email', 'gender', 'dob', 'address', 'class', 'section', 'roll_number', 'admission_date', 'profile_photo', 'status'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
