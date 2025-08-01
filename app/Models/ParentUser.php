<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentUser extends Model
{
    protected $fillable = ['student_id', 'name', 'phone', 'email', 'profession'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
